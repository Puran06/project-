// Function to update the user profile
function updateProfile() {
    // Retrieve the input values from the user (you can use DOM manipulation here)
    var fullNameInput = document.getElementById("full-name-input").value;
    var contactNumberInput = document.getElementById("contact-number-input").value;
    var locationInput = document.getElementById("location-input").value;
  
    // Validate the input values (you can add more validation as needed)
    if (!fullNameInput || !contactNumberInput || !locationInput) {
      alert("Please fill in all the required fields.");
      return;
    }
  
    // You can use AJAX to send the updated profile data to the server and handle the response
    // For simplicity, we'll just display an alert indicating that the profile has been updated
    alert("Profile updated successfully!");
  }
  
  // Function to change the user password
  function changePassword() {
    // Retrieve the input values from the user (you can use DOM manipulation here)
    var currentPasswordInput = document.getElementById("current-password-input").value;
    var newPasswordInput = document.getElementById("new-password-input").value;
    var confirmPasswordInput = document.getElementById("confirm-password-input").value;
  
    // Validate the input values (you can add more validation as needed)
    if (!currentPasswordInput || !newPasswordInput || !confirmPasswordInput) {
      alert("Please fill in all the required fields.");
      return;
    }
  
    // Check if the new password matches the confirmation password
    if (newPasswordInput !== confirmPasswordInput) {
      alert("New password and confirmation password do not match.");
      return;
    }
  
    // You can use AJAX to send the password change data to the server and handle the response
    // For simplicity, we'll just display an alert indicating that the password has been changed
    alert("Password changed successfully!");
  }
  
  // Function to handle the booking form submission
  function bookNow() {
    // Retrieve the input values from the user (you can use DOM manipulation here)
    var locationInput = document.getElementById("location").value;
    var vehicleTypeInput = document.getElementById("vehicle-type").value;
    var entryTimeInput = document.getElementById("entry-time").value;
    var exitTimeInput = document.getElementById("exit-time").value;
  
    // Validate the input values (you can add more validation as needed)
    if (!locationInput || !vehicleTypeInput || !entryTimeInput || !exitTimeInput) {
      alert("Please fill in all the required fields.");
      return;
    }
  
    // You can use AJAX to send the booking data to the server and handle the response
    // For simplicity, we'll just display an alert indicating that the booking is successful
    alert("Booking successful!");
  }
  