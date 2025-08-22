function generateQRCode() {
    const qrText = document.getElementById('qrText').value;
    const qrCodeContainer = document.getElementById('qrCodeContainer');
    const downloadBtn = document.getElementById('downloadBtn');
    
    qrCodeContainer.innerHTML = '';
    if (qrText.trim() === '') {
        alert('Please enter text or URL');
        return;
    }
    
    const qrCode = new QRCode(qrCodeContainer, {
        text: qrText,
        width: 256,
        height: 256,
    });

    downloadBtn.style.display = 'block';
}

function downloadQRCode() {
    const qrCodeContainer = document.getElementById('qrCodeContainer');
    const qrCodeImg = qrCodeContainer.querySelector('img');
    const qrCodeSrc = qrCodeImg.src;

    const link = document.createElement('a');
    link.href = qrCodeSrc;
    link.download = 'qrcode.png';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}


const script = document.createElement('script');
script.src = 'https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js';
document.head.appendChild(script);







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
