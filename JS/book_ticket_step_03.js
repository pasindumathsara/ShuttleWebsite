window.onload = function () {
    // Simulating fetching data from previous selections (can be from localStorage, sessionStorage, or passed via URL query parameters)
    
    // Assuming we have the data saved in localStorage (from previous steps or a selection page)
    const shuttleService = localStorage.getItem('shuttleService') || "Express Bus";
    const startJourney = localStorage.getItem('startJourney') || "Central Station";
    const valuableTimePeriod = localStorage.getItem('valuableTimePeriod') || "Sept 2024";
    const time = localStorage.getItem('time') || "08:30 AM";
    const time1 = localStorage.getItem('time1') || "09:45 AM";
    const total = localStorage.getItem('total') || "$25.00";

    // Assign values to the respective fields in the form
    document.getElementById('name').value = shuttleService;
    document.getElementById('start').value = startJourney;
    document.getElementById('month').value = valuableTimePeriod;
    document.getElementById('time').value = time;
    document.getElementById('time1').value = time1;
    document.getElementById('tot').value = total;
};
