(function($) {
    'use strict';

    document.addEventListener("DOMContentLoaded", function() {
        const imageLinks = document.querySelectorAll('figure.wp-block-image.size-large');

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

        const images = Array.from(imageLinks).map(link => getLargestImageURL(link.querySelector('img')));

        let currentIndex = 0;

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

        imageLinks.forEach((link, index) => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                currentIndex = index;
                img.src = images[currentIndex];
                showaggGallery();
            });
        });

        function showaggGallery() {
            aggGallery.style.display = 'flex';
        }

        function hideaggGallery() {
            aggGallery.style.display = 'none';
        }

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
    });
})(jQuery);