(function($) {
    'use strict';

    document.addEventListener("DOMContentLoaded", function() {
        // GSAP Animation
        gsap.registerPlugin(ScrollTrigger);
        
        const settings = window.aggSettings || {
            animation_type: 'fade-up',
            animation_duration: 1,
            animation_stagger: 0.2,
            hover_effect: 'zoom'
        };

        function setupHoverEffects() {
            const images = document.querySelectorAll('figure.wp-block-image');
            
            images.forEach(figure => {
                // Create hover animation based on selected effect
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
                                transformPerspective: 350, // Decreased for more pronounced effect
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
        }


        function setupLightbox() {
            // Lightbox functionality
            const imageLinks = document.querySelectorAll('figure.wp-block-image.size-large');
            let currentIndex = 0;

            // Function to get the largest image URL from srcset
            function getLargestImageURL(imgElement) {
                const srcset = imgElement.getAttribute('srcset');
                if (!srcset) {
                    return imgElement.src;
                }
                const sources = srcset.split(',').map(src => {
                    const [url, width] = src.trim().split(' ');
                    return { url, width: parseInt(width) };
                });
                sources.sort((a, b) => b.width - a.width);
                return sources[0].url;
            }

            // Create an array of high-resolution image URLs
            const images = Array.from(imageLinks).map(link => getLargestImageURL(link.querySelector('img')));

            // Create gallery modal elements
            const aggGallery = document.createElement('div');
            aggGallery.id = 'aggGallery';

            const aggGalleryContent = document.createElement('div');
            aggGalleryContent.id = 'aggGallery-content';

            const img = document.createElement('img');
            img.id = 'aggGallery-image';

            const closeBtn = document.createElement('span');
            closeBtn.id = 'aggGallery-close';
            closeBtn.innerHTML = '&times;';

            const prevBtn = document.createElement('span');
            prevBtn.id = 'aggGallery-prev';
            prevBtn.innerHTML = '&#10094;';

            const nextBtn = document.createElement('span');
            nextBtn.id = 'aggGallery-next';
            nextBtn.innerHTML = '&#10095;';

            aggGalleryContent.appendChild(img);
            aggGallery.appendChild(aggGalleryContent);
            aggGallery.appendChild(closeBtn);
            aggGallery.appendChild(prevBtn);
            aggGallery.appendChild(nextBtn);
            document.body.appendChild(aggGallery);

            // Functions to show and hide the aggGallery
            function showaggGallery() {
                aggGallery.style.display = 'flex';
            }

            function hideaggGallery() {
                aggGallery.style.display = 'none';
            }

            // Add click events to images
            imageLinks.forEach((link, index) => {
                link.style.cursor = 'pointer';
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    currentIndex = index;
                    img.src = images[currentIndex];
                    showaggGallery();
                });
            });

            // Add event listeners for navigation and close actions
            closeBtn.addEventListener('click', hideaggGallery);

            aggGallery.addEventListener('click', function(e) {
                if (e.target === aggGallery || e.target === aggGalleryContent) {
                    hideaggGallery();
                }
            });

            prevBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                img.src = images[currentIndex];
            });

            nextBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                currentIndex = (currentIndex + 1) % images.length;
                img.src = images[currentIndex];
            });
        }

        // Animation configuration based on type
        function getAnimationConfig() {
            const baseConfig = {
                opacity: 0,
                duration: settings.animation_duration,
                stagger: settings.animation_stagger,
                scrollTrigger: {
                    trigger: 'figure.wp-block-image',
                    start: "top bottom-=100",
                    toggleActions: "play none none reverse"
                },
                onComplete: () => {
                    setupLightbox();
                    setupHoverEffects();
                }
            };

            switch(settings.animation_type) {
                case 'fade':
                    return baseConfig;
                case 'fade-up':
                    return {
                        ...baseConfig,
                        y: 50,
                        ease: "power2.out"
                    };
                case 'fade-left':
                    return {
                        ...baseConfig,
                        x: -50,
                        ease: "power2.out"
                    };
                case 'zoom':
                    return {
                        ...baseConfig,
                        scale: 0.5,
                        ease: "back.out(1.7)"
                    };
                default:
                    return baseConfig;
            }
        }

        // Apply animation
        gsap.from('figure.wp-block-image', getAnimationConfig());
    });
})(jQuery);