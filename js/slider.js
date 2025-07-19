const slides = ['images/slider/slide1.jpg', 'images/slider/slide2.jpg', 'images/slider/slide3.jpg'];
let currentSlide = 0;
const slider = document.getElementById('slider');

function showSlide(index) {
    slider.innerHTML = `<img src="${slides[index]}" alt="Slayder" class="w-full h-full object-cover">`;
}

document.getElementById('prev-slide').addEventListener('click', () => {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    showSlide(currentSlide);
});

document.getElementById('next-slide').addEventListener('click', () => {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
});

setInterval(() => {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
}, 5000);