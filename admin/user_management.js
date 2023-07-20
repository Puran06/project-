// Function to calculate the total money based on entry and exit times and vehicle type
function calculateTotalMoney(entryTime, exitTime, vehicleType) {
  const perHourRate = {
    Bike: 10,
    Car: 20,
    Bus: 30,
    Truck: 50,
  };

  const entry = new Date(entryTime);
  const exit = new Date(exitTime);
  const hours = Math.abs(exit - entry) / 36e5; // 36e5 is the number of milliseconds in an hour

  return (perHourRate[vehicleType] * hours).toFixed(2);
}

// Function to fetch all users from the server and populate the table
function getUsers() {
  fetch('user_management.php?action=getUsers')
    .then(response => response.json())
    .then(users => {
      const tableBody = document.querySelector('#usersTable tbody');
      tableBody.innerHTML = '';

      users.forEach(user => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${user.user_id}</td>
          <td>${user.full_name}</td>
          <td>${user.email}</td>
          <td>${user.contact_number}</td>
          <td>${user.location}</td>
          <td>${user.vehicle_type}</td>
          <td>${user.entry_time}</td>
          <td>${user.exit_time}</td>
          <td>${calculateTotalMoney(user.entry_time, user.exit_time, user.vehicle_type)}</td>
          <td>${user.role}</td>
          <td>
            <button class="editButton" data-id="${user.user_id}">Edit</button>
            <button class="deleteButton" data-id="${user.user_id}">Delete</button>
          </td>
        `;

        tableBody.appendChild(row);
      });
    });
}

// Function to handle the form submission for adding/editing users
function handleUserFormSubmit(event) {
  event.preventDefault();

  const userId = document.querySelector('#userId').value;
  const fullName = document.querySelector('#fullName').value;
  const email = document.querySelector('#email').value;
  const password = document.querySelector('#password').value;
  const contactNumber = document.querySelector('#contactNumber').value;
  const location = document.querySelector('#location').value;
  const vehicleType = document.querySelector('#vehicleType').value;
  const entryTime = document.querySelector('#entryTime').value;
  const exitTime = document.querySelector('#exitTime').value;
  const role = document.querySelector('#role').value;

  if (userId) {
    // Editing existing user
    editUser(userId, fullName, email, password, contactNumber, location, vehicleType, entryTime, exitTime, role);
  } else {
    // Adding new user
    addUser(fullName, email, password, contactNumber, location, vehicleType, entryTime, exitTime, role);
  }
}

// Function to add a new user
function addUser(fullName, email, password, contactNumber, location, vehicleType, entryTime, exitTime, role) {
  const formData = new FormData();
  formData.append('action', 'addUser');
  formData.append('fullName', fullName);
  formData.append('email', email);
  formData.append('password', password);
  formData.append('contactNumber', contactNumber);
  formData.append('location', location);
  formData.append('vehicleType', vehicleType);
  formData.append('entryTime', entryTime);
  formData.append('exitTime', exitTime);
  formData.append('role', role);

  fetch('user_management.php', {
    method: 'POST',
    body: formData
  })
    .then(response => response.text())
    .then(result => {
      console.log(result);
      resetForm();
      getUsers();
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

// Function to edit an existing user
function editUser(userId, fullName, email, password, contactNumber, location, vehicleType, entryTime, exitTime, role) {
  const formData = new FormData();
  formData.append('action', 'editUser');
  formData.append('userId', userId);
  formData.append('fullName', fullName);
  formData.append('email', email);
  formData.append('password', password);
  formData.append('contactNumber', contactNumber);
  formData.append('location', location);
  formData.append('vehicleType', vehicleType);
  formData.append('entryTime', entryTime);
  formData.append('exitTime', exitTime);
  formData.append('role', role);

  fetch('user_management.php', {
    method: 'POST',
    body: formData
  })
    .then(response => response.text())
    .then(result => {
      console.log(result);
      resetForm();
      getUsers();
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

// Function to delete a user
function deleteUser(userId) {
  const formData = new FormData();
  formData.append('action', 'deleteUser');
  formData.append('userId', userId);

  fetch('user_management.php', {
    method: 'POST',
    body: formData
  })
    .then(response => response.text())
    .then(result => {
      console.log(result);
      getUsers();
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

// Function to reset the form fields
function resetForm() {
  document.querySelector('#userForm').reset();
  document.querySelector('#userId').value = '';
  document.querySelector('#saveButton').innerText = 'Save';
}

// Function to handle edit and delete button clicks
function handleTableButtonClick(event) {
  const target = event.target;

  if (target.classList.contains('editButton')) {
    const userId = target.getAttribute('data-id');
    editButtonClicked(userId);
  } else if (target.classList.contains('deleteButton')) {
    const userId = target.getAttribute('data-id');
    deleteButtonClicked(userId);
  }
}

// Function to handle the edit button click
function editButtonClicked(userId) {
  fetch(`user_management.php?action=getUser&userId=${userId}`)
    .then(response => response.json())
    .then(user => {
      document.querySelector('#userId').value = user.user_id;
      document.querySelector('#fullName').value = user.full_name;
      document.querySelector('#email').value = user.email;
      document.querySelector('#password').value = user.password;
      document.querySelector('#contactNumber').value = user.contact_number;
      document.querySelector('#location').value = user.location;
      document.querySelector('#vehicleType').value = user.vehicle_type;
      document.querySelector('#entryTime').value = user.entry_time;
      document.querySelector('#exitTime').value = user.exit_time;
      document.querySelector('#role').value = user.role;
      document.querySelector('#totalMoney').value = user.total_money; // Update the total money field
      document.querySelector('#saveButton').innerText = 'Update';
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

// Function to handle the delete button click
function deleteButtonClicked(userId) {
  if (confirm('Are you sure you want to delete this user?')) {
    deleteUser(userId);
  }
}

// Initial setup
document.addEventListener('DOMContentLoaded', () => {
  getUsers();
  document.querySelector('#userForm').addEventListener('submit', handleUserFormSubmit);
  document.querySelector('#usersTable').addEventListener('click', handleTableButtonClick);
});
