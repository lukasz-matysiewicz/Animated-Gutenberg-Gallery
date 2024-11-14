(function($) {
    'use strict';
    
    document.addEventListener('DOMContentLoaded', function() {
        const buttonGroups = document.querySelectorAll('.agg-button-group');
        const previewButton = document.querySelector('.agg-preview-button');
        const previewItems = document.querySelectorAll('.agg-preview-item');
        const modal = createModal();

        function createModal() {
            const modal = document.createElement('div');
            modal.id = 'aggGallery';
            modal.style.cssText = 'display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.9); z-index: 999999;';
            
            const content = document.createElement('div');
            content.id = 'aggGallery-content';
            content.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;';
            
            const img = document.createElement('img');
            img.id = 'aggGallery-image';
            img.style.cssText = 'max-width: 90%; max-height: 90vh; object-fit: contain;';
            
            const closeBtn = document.createElement('span');
            closeBtn.id = 'aggGallery-close';
            closeBtn.innerHTML = '&times;';
            closeBtn.style.cssText = 'position: absolute; top: 20px; right: 30px; color: #fff; font-size: 40px; font-weight: bold; cursor: pointer; z-index: 10000;';
        
            const prevBtn = document.createElement('span');
            prevBtn.id = 'aggGallery-prev';
            prevBtn.innerHTML = '&#10094;';
            prevBtn.style.cssText = 'position: absolute; left: 30px; top: 50%; transform: translateY(-50%); color: #fff; font-size: 60px; cursor: pointer; z-index: 10000;';
        
            const nextBtn = document.createElement('span');
            nextBtn.id = 'aggGallery-next';
            nextBtn.innerHTML = '&#10095;';
            nextBtn.style.cssText = 'position: absolute; right: 30px; top: 50%; transform: translateY(-50%); color: #fff; font-size: 60px; cursor: pointer; z-index: 10000;';
        
            content.appendChild(img);
            modal.appendChild(content);
            modal.appendChild(closeBtn);
            modal.appendChild(prevBtn);
            modal.appendChild(nextBtn);
            document.body.appendChild(modal);
        
            let currentIndex = 0;
            const previewImages = Array.from(document.querySelectorAll('.agg-preview-item img'));
        
            closeBtn.addEventListener('click', () => {
                modal.style.display = 'none';
            });
        
            prevBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                currentIndex = (currentIndex - 1 + previewImages.length) % previewImages.length;
                img.src = previewImages[currentIndex].src;
            });
        
            nextBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                currentIndex = (currentIndex + 1) % previewImages.length;
                img.src = previewImages[currentIndex].src;
            });
        
            modal.addEventListener('click', (e) => {
                if (e.target === modal || e.target === content) {
                    modal.style.display = 'none';
                }
            });
        
            return { modal, img, setIndex: (index) => { currentIndex = index; } };
        }

        // Setup lightbox clicks
        previewItems.forEach((item, index) => {
            const img = item.querySelector('img');
            item.style.cursor = 'pointer';
            item.addEventListener('click', () => {
                modal.img.src = img.src;
                modal.setIndex(index);
                modal.modal.style.display = 'flex';
            });
        });

        buttonGroups.forEach(group => {
            const buttons = group.querySelectorAll('.agg-button');
            const hiddenInput = group.nextElementSibling;
            
            buttons.forEach(button => {
                button.addEventListener('click', () => {
                    group.querySelectorAll('.agg-button').forEach(btn => {
                        btn.classList.remove('active');
                    });
                    button.classList.add('active');
                    hiddenInput.value = button.dataset.value;
                    
                    if (hiddenInput.id === 'hover_effect') {
                        updateHoverEffects(button.dataset.value);
                    }
                });
            });
        });

        if (previewButton && previewItems.length) {
            previewButton.addEventListener('click', function() {
                const animationType = document.getElementById('animation_type').value;
                const duration = parseFloat(document.querySelector('input[name="agg_settings[animation_duration]"]').value);
                const stagger = parseFloat(document.querySelector('input[name="agg_settings[animation_stagger]"]').value);

                gsap.set(previewItems, { clearProps: "all" });

                switch(animationType) {
                    case 'fade':
                        gsap.from(previewItems, {
                            opacity: 0,
                            duration: duration,
                            stagger: stagger
                        });
                        break;
                    case 'fade-up':
                        gsap.from(previewItems, {
                            opacity: 0,
                            y: 50,
                            duration: duration,
                            stagger: stagger
                        });
                        break;
                    case 'fade-left':
                        gsap.from(previewItems, {
                            opacity: 0,
                            x: -50,
                            duration: duration,
                            stagger: stagger
                        });
                        break;
                    case 'zoom':
                        gsap.from(previewItems, {
                            opacity: 0,
                            scale: 0.5,
                            duration: duration,
                            stagger: stagger,
                            ease: "back.out(1.7)"
                        });
                        break;
                }

                // Re-apply hover effect after animation
                const hoverEffect = document.getElementById('hover_effect').value;
                updateHoverEffects(hoverEffect);
            });
        }

        function updateHoverEffects(effect) {
            previewItems.forEach(item => {
                switch(effect) {
                    case 'zoom':
                        item.addEventListener('mouseenter', () => {
                            gsap.to(item, { scale: 1.05, duration: 0.3 });
                        });
                        item.addEventListener('mouseleave', () => {
                            gsap.to(item, { scale: 1, duration: 0.3 });
                        });
                        break;
                    case 'lift':
                        item.addEventListener('mouseenter', () => {
                            gsap.to(item, { y: -15, duration: 0.3 });
                        });
                        item.addEventListener('mouseleave', () => {
                            gsap.to(item, { y: 0, duration: 0.3 });
                        });
                        break;
                    case 'tilt':
                        item.addEventListener('mousemove', (e) => {
                            const bounds = item.getBoundingClientRect();
                            const mouseX = e.clientX - bounds.left;
                            const mouseY = e.clientY - bounds.top;
                            const centerX = bounds.width / 2;
                            const centerY = bounds.height / 2;
                            const rotateX = (mouseY - centerY) / 10;
                            const rotateY = (centerX - mouseX) / 10;

                            gsap.to(item, {
                                rotateX: rotateX,
                                rotateY: rotateY,
                                scale: 1.05,
                                transformPerspective: 300,
                                duration: 0.5
                            });
                        });
                        item.addEventListener('mouseleave', () => {
                            gsap.to(item, {
                                rotateX: 0,
                                rotateY: 0,
                                scale: 1,
                                duration: 0.5
                            });
                        });
                        break;
                }
            });
        }

        // Initialize hover effects
        const initialHoverEffect = document.getElementById('hover_effect').value;
        updateHoverEffects(initialHoverEffect);
    });
})(jQuery);