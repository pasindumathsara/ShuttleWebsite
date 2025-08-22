let currentStep = 4;

function nextStep() {
    if (currentStep < 4) {
        currentStep++;
        updateProgressBar();
    }
}

function updateProgressBar() {
    const progressBar = document.getElementById('progress-bar');
    const steps = document.querySelectorAll('.progress-step');

    steps.forEach((step, index) => {
        if (index < currentStep) {
            step.classList.add('active');
        } else {
            step.classList.remove('active');
        }
    });

    const progressPercent = ((currentStep - 1) / (steps.length - 1)) * 100;
    progressBar.style.width = progressPercent + '%';
}

document.addEventListener('DOMContentLoaded', updateProgressBar);


const acceptTermsCheckbox = document.getElementById('acceptTerms');
        const submitBtn = document.getElementById('submitBtn');

        acceptTermsCheckbox.addEventListener('change', function() {
            submitBtn.disabled = !this.checked;
        });