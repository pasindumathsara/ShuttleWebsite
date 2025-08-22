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


document.addEventListener('DOMContentLoaded', () => {
    const boxes = document.querySelectorAll('.box');

    const checkVisibility = () => {
        const windowHeight = window.innerHeight;
        boxes.forEach(box => {
            const boxTop = box.getBoundingClientRect().top;
            const boxVisible = boxTop < windowHeight * 0.8; // Trigger animation when 80% of the box is visible
            if (boxVisible) {
                box.classList.add('visible');
            }
        });
    };

    window.addEventListener('scroll', checkVisibility);
    checkVisibility(); // Initial check in case the elements are already in view
});







