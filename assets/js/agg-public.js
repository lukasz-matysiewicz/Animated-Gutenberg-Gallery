(function($) {
    'use strict';

    document.addEventListener("DOMContentLoaded", function() {
        gsap.registerPlugin(ScrollTrigger);

        // Get settings from PHP
        const settings = window.aggSettings || {
            animation_type: 'fade-up',
            animation_duration: 1,
            animation_stagger: 0.2,
            hover_effect: 'zoom'
        };

        const lenis = new Lenis({
            duration: 1.2,
            easing: (t) => (t === 1 ? 1 : 1 - Math.pow(2, -10 * t)),
            smoothWheel: true,
            wheelMultiplier: 1,
            touchMultiplier: 2,
        });

        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }

        requestAnimationFrame(raf);
        lenis.on('scroll', ScrollTrigger.update);

        function setupLightbox() {
            if (!document.getElementById('aggGallery')) {
                const lightboxHtml = `
                    <div id="aggGallery">
                        <div id="aggGallery-content">
                            <img id="aggGallery-image" src="" alt="">
                            <span id="aggGallery-close">&times;</span>
                            <span id="aggGallery-prev">&#10094;</span>
                            <span id="aggGallery-next">&#10095;</span>
                        </div>
                    </div>
                `;
                document.body.insertAdjacentHTML('beforeend', lightboxHtml);
            }

            const modal = document.getElementById('aggGallery');
            const modalContent = document.getElementById('aggGallery-content');
            const modalImg = document.getElementById('aggGallery-image');
            const closeBtn = document.getElementById('aggGallery-close');
            const prevBtn = document.getElementById('aggGallery-prev');
            const nextBtn = document.getElementById('aggGallery-next');
            let currentGallery = null;
            let currentIndex = 0;

            function showLightbox() {
                modal.style.display = 'flex';
                gsap.fromTo(modal, 
                    { opacity: 0 }, 
                    { opacity: 1, duration: 0.5 }
                );
            }

            function hideLightbox() {
                gsap.to(modal, {
                    opacity: 0,
                    duration: 0.5,
                    onComplete: () => {
                        modal.style.display = 'none';
                    }
                });
            }

            function getLargestImageURL(img) {
                if (!img.srcset) return img.src;
                const sources = img.srcset.split(',')
                    .map(src => {
                        const [url, width] = src.trim().split(' ');
                        return { url, width: parseInt(width) };
                    })
                    .sort((a, b) => b.width - a.width);
                return sources[0].url;
            }

            function navigateImage(direction) {
                if (!currentGallery) return;
                const images = currentGallery.querySelectorAll('figure.wp-block-image img');
                currentIndex = (currentIndex + direction + images.length) % images.length;
                modalImg.src = getLargestImageURL(images[currentIndex]);
            }

            const lightboxGalleries = document.querySelectorAll('.wp-block-gallery.agg-lightbox');
            lightboxGalleries.forEach(gallery => {
                const images = gallery.querySelectorAll('figure.wp-block-image img');
                images.forEach((img, index) => {
                    img.style.cursor = 'pointer';
                    img.addEventListener('click', (e) => {
                        e.preventDefault();
                        currentGallery = gallery;
                        currentIndex = index;
                        modalImg.src = getLargestImageURL(img);
                        showLightbox();
                    });
                });
            });

            closeBtn.onclick = hideLightbox;
            modal.onclick = (e) => {
                if (e.target === modal || e.target === modalContent) hideLightbox();
            };
            
            prevBtn.onclick = (e) => {
                e.stopPropagation();
                navigateImage(-1);
            };
            
            nextBtn.onclick = (e) => {
                e.stopPropagation();
                navigateImage(1);
            };

            document.addEventListener('keydown', (e) => {
                if (modal.style.display === 'none') return;
                
                switch(e.key) {
                    case 'ArrowLeft':
                        navigateImage(-1);
                        break;
                    case 'ArrowRight':
                        navigateImage(1);
                        break;
                    case 'Escape':
                        hideLightbox();
                        break;
                }
            });
        }

        setupLightbox();


        // Setup Animations per figure instead of per gallery
        const animatedGalleries = document.querySelectorAll('.wp-block-gallery.agg-animated');

        animatedGalleries.forEach(gallery => {
            const figures = gallery.querySelectorAll('figure.wp-block-image');
            
            figures.forEach((figure, index) => {
                let animationConfig = {
                    opacity: 0,
                    duration: settings.animation_duration,
                    scrollTrigger: {
                        trigger: figure,
                        start: "top bottom-=100",
                        toggleActions: "play none none reverse"
                    }
                };

                switch(settings.animation_type) {
                    case 'fade-up':
                        animationConfig.y = 50;
                        break;
                    case 'fade-left':
                        animationConfig.x = -50;
                        break;
                    case 'zoom':
                        animationConfig.scale = 0.5;
                        animationConfig.ease = "back.out(1.7)";
                        break;
                    case 'alternate-scroll':
                        // New animation type
                        const initialY = index % 2 === 0 ? 100 : -100;
                        gsap.set(figure, { y: initialY });
                        
                        gsap.to(figure, {
                            y: 0,
                            ease: 'none',
                            scrollTrigger: {
                                trigger: figure,
                                start: 'top bottom',
                                end: 'top center',
                                scrub: true
                            }
                        });
                        return; // Skip default animation
                }

                gsap.from(figure, animationConfig);

                // Hover effects
                switch(settings.hover_effect) {
                    case 'zoom':
                        figure.addEventListener('mouseenter', () => {
                            gsap.to(figure, {
                                scale: 1.05,
                                duration: 0.3,
                                ease: "power2.out"
                            });
                        });
                        figure.addEventListener('mouseleave', () => {
                            gsap.to(figure, {
                                scale: 1,
                                duration: 0.3,
                                ease: "power2.out"
                            });
                        });
                        break;

                    case 'lift':
                        figure.addEventListener('mouseenter', () => {
                            gsap.to(figure, {
                                y: -15,
                                duration: 0.3,
                                ease: "power2.out"
                            });
                        });
                        figure.addEventListener('mouseleave', () => {
                            gsap.to(figure, {
                                y: 0,
                                duration: 0.3,
                                ease: "power2.out"
                            });
                        });
                        break;

                    case 'tilt':
                        figure.addEventListener('mousemove', (e) => {
                            const bounds = figure.getBoundingClientRect();
                            const mouseX = e.clientX - bounds.left;
                            const mouseY = e.clientY - bounds.top;
                            const centerX = bounds.width / 2;
                            const centerY = bounds.height / 2;
                            const rotateX = (mouseY - centerY) / 5;
                            const rotateY = (centerX - mouseX) / 5;

                            gsap.to(figure, {
                                rotateX: rotateX,
                                rotateY: rotateY,
                                scale: 1.05,
                                transformPerspective: 350,
                                duration: 0.5,
                                ease: "power2.out"
                            });
                        });
                        figure.addEventListener('mouseleave', () => {
                            gsap.to(figure, {
                                rotateX: 0,
                                rotateY: 0,
                                scale: 1,
                                duration: 0.5,
                                ease: "power2.out"
                            });
                        });
                        break;
                }
            });
        });
    });
})(jQuery);