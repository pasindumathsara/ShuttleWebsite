

        document.getElementById('bookingForm').addEventListener('submit', function(event) {
            event.preventDefault();
            alert('Ticket booked successfully!');
        });
      
        let slideIndex = 0;
carousel();

function carousel() {
    let slides = document.querySelectorAll('.hero-image');
    if (slides.length > 0) {
        slides.forEach(slide => {
            slide.style.opacity = '0';
        });
        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1;
        }
        slides[slideIndex - 1].style.opacity = '1';
        setTimeout(carousel, 5000); // Change image every 5 seconds (adjust as needed)
    }
}