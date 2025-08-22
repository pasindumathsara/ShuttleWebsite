let currentIndex = 0;
const slides = document.querySelector('.slides');
const totalSlides = slides.children.length;

document.querySelector('.next').addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % totalSlides;
    updateSlide();
});

document.querySelector('.prev').addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
    updateSlide();
});

function updateSlide() {
    const offset = -currentIndex * 100;
    slides.style.transform = `translateX(${offset}%)`;
}
