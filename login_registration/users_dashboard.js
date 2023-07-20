
function updateProfile() {
  // Retrieve updated values from user input (e.g., form fields)
  var updatedFullName = prompt("Enter your updated full name:");
  var updatedContactNumber = prompt("Enter your updated contact number:");
  var updatedLocation = prompt("Enter your updated location:");
  var updatedVehicleType = prompt("Enter your updated vehicle type:");

  // Perform AJAX request to update the profile on the server
  // You can use a library like Axios or fetch API to perform the AJAX request
  // Pass the updated values to the server-side PHP script for processing
  // Example using fetch API:
  fetch('update_profile.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
      },
      body: JSON.stringify({
          full_name: updatedFullName,
          contact_number: updatedContactNumber,
          location: updatedLocation,
          vehicle_type: updatedVehicleType
      }),
  })
  .then(response => response.json())
  .then(data => {
      // Handle the response from the server (e.g., display success message, update UI)
      alert(data.message);
      // Refresh the user dashboard to reflect the updated profile
      window.location.reload();
  })
  .catch(error => {
      console.error('Error:', error);
  });
}

function changePassword() {
  // Retrieve the new password from the user input (e.g., form field)
  var newPassword = prompt("Enter your new password:");

  // Perform AJAX request to change the password on the server
  // You can use a library like Axios or fetch API to perform the AJAX request
  // Pass the new password to the server-side PHP script for processing
  // Example using fetch API:
  fetch('change_password.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
      },
      body: JSON.stringify({
          password: newPassword
      }),
  })
  .then(response => response.json())
  .then(data => {
      // Handle the response from the server (e.g., display success message, update UI)
      alert(data.message);
  })
  .catch(error => {
      console.error('Error:', error);
  });
}