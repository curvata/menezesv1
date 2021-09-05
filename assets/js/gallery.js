import GLightbox from 'glightbox';
require('glightbox/dist/css/glightbox.css');

const lightbox = GLightbox({
    touchNavigation: true,
    loop: true,
    openEffect: 'zoom',
    closeEffect: 'fade',
    cssEfects: {
        fade: { in: 'fadeIn', out: 'fadeOut' },
        zoom: { in: 'zoomIn', out: 'zoomOut' }
    }
});
