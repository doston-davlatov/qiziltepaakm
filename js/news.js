document.addEventListener('DOMContentLoaded', function () {
    const swiper = new Swiper('.featured-news-slider', {
        // Display one slide at a time
        slidesPerView: 1,
        spaceBetween: 0,
        // Auto-rotation
        autoplay: {
            delay: 5000, // 5 seconds per slide
            disableOnInteraction: false,
        },
        // Pagination
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        // Responsive breakpoints
        breakpoints: {
            // Ensure it remains one slide on all screen sizes
            640: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
            768: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
            1024: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
        },
    });
});