// Function to update the user profile
function updateProfile() {
  var fullNameInput = document.getElementById("full-name-input").value;
  var contactNumberInput = document.getElementById("contact-number-input").value;
  var locationInput = document.getElementById("location-input").value;

  // Validate input fields
  if (!fullNameInput || !contactNumberInput || !locationInput) {
      alert("Please fill in all the required fields.");
      return;
  }

  // Prepare data to send to the server
  var data = {
      full_name: fullNameInput,
      contact_number: contactNumberInput,
      location: locationInput
  };

  // Make an AJAX request to update the profile
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "update_profile.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
              alert(xhr.responseText);
          } else {
              alert("Profile update failed.");
          }
      }
  };

  xhr.send(JSON.stringify(data));
}

// Function to change the user password
function changePassword() {
  var newPassword = prompt("Enter your new password:");

  // Validate the new password if needed
  if (!newPassword) {
      alert("Please enter a valid new password.");
      return;
  }

  // Prepare data to send to the server
  var data = {
      new_password: newPassword
  };

  // Make an AJAX request to change the password
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "change_password.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
              alert(xhr.responseText);
          } else {
              alert("Password change failed.");
          }
      }
  };

  xhr.send(JSON.stringify(data));
}
