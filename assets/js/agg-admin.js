(function($) {
    'use strict';
    
    document.addEventListener('DOMContentLoaded', function() {
        const buttonGroups = document.querySelectorAll('.agg-button-group');
        const previewButton = document.querySelector('.agg-preview-button');
        const previewItems = document.querySelectorAll('.agg-preview-item');

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

                gsap.set(previewItems, { clearProps: "all" });

                switch(animationType) {
                    case 'fade':
                        gsap.from(previewItems, {
                            opacity: 0,
                            duration: duration
                        });
                        break;
                    case 'fade-up':
                        gsap.from(previewItems, {
                            opacity: 0,
                            y: 50,
                            duration: duration
                        });
                        break;
                    case 'fade-left':
                        gsap.from(previewItems, {
                            opacity: 0,
                            x: -50,
                            duration: duration
                        });
                        break;
                    case 'zoom':
                        gsap.from(previewItems, {
                            opacity: 0,
                            scale: 0.5,
                            duration: duration,
                            ease: "back.out(1.7)"
                        });
                        break;
                }

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

        const initialHoverEffect = document.getElementById('hover_effect').value;
        updateHoverEffects(initialHoverEffect);
    });
})(jQuery);