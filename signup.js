document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('signup-form');
    
    form.addEventListener('submit', function(event) {
        // Prevent the form from submitting to display the alert
        event.preventDefault();
        
        // Display the success alert
        alert('Successfully registered!');
        
        // You can optionally submit the form here if you want:
        // form.submit();
    });
});
