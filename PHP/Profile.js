

const slides = document.querySelector('.slides');
const images = slides.querySelectorAll('img');
const totalImages = images.length;
let currentIndex = 0;

function showNextImage() {
    currentIndex++;
    if (currentIndex >= totalImages) {
        currentIndex = 0;
    }
    const offset = -currentIndex * 100;
    slides.style.transform = `translateX(${offset}%)`;
}

setInterval(showNextImage, 3000); // Change image every 3 seconds
