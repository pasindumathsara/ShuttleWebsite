document.getElementById('done-btn').addEventListener('click', function() {
    const selectedOption = document.getElementById('options').value;
    alert(`You selected ${selectedOption === '1' ? 'Student' : 'Staff'}`);
});
