<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vpmsdd";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get users from the database
function getUsers() {
    global $conn;
    $sql = "SELECT * FROM Users";
    $result = $conn->query($sql);
    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    return $users;
}

// Add a new user to the database
function addUser($fullName, $email, $password, $contactNumber, $location, $vehicleType, $entryTime, $exitTime, $role) {
    global $conn;

    // Calculate total money based on entry and exit times
    $perHourRate = [
        'Bike' => 10,
        'Car' => 20,
        'Bus' => 30,
        'Truck' => 50
    ];
    $entry = new DateTime($entryTime);
    $exit = new DateTime($exitTime);
    $hours = $entry->diff($exit)->h;
    $totalMoney = $perHourRate[$vehicleType] * $hours;

    $sql = "INSERT INTO Users (full_name, email, password, contact_number, location, vehicle_type, entry_time, exit_time, total_money, role)
            VALUES ('$fullName', '$email', '$password', '$contactNumber', '$location', '$vehicleType', '$entryTime', '$exitTime', '$totalMoney', '$role')";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}



// Edit an existing user in the database
function editUser($userId, $fullName, $email, $password, $contactNumber, $location, $vehicleType, $entryTime, $exitTime, $role) {
    global $conn;
    
    // Calculate total money based on entry and exit times
    $perHourRate = [
        'Bike' => 10,
        'Car' => 20,
        'Bus' => 30,
        'Truck' => 50
    ];
    $entry = new DateTime($entryTime);
    $exit = new DateTime($exitTime);
    $hours = $entry->diff($exit)->h;
    $totalMoney = $perHourRate[$vehicleType] * $hours;

    $sql = "UPDATE Users SET full_name='$fullName', email='$email', password='$password', contact_number='$contactNumber', 
            location='$location', vehicle_type='$vehicleType', entry_time='$entryTime', exit_time='$exitTime', 
            total_money='$totalMoney', role='$role' WHERE user_id='$userId'";

    if ($conn->query($sql) === TRUE) {
        // Update the total money value in the user variable as well
        $user = getUser($userId);
        $user['total_money'] = $totalMoney;
        return $user;
    } else {
        return null;
    }
}


// Check if the request is for getUser
if (isset($_GET['action']) && $_GET['action'] == 'getUser') {
    $userId = $_GET['userId'];
    $user = getUser($userId);
    echo json_encode($user);
    exit();
}

// Add the following function to retrieve a single user from the database
function getUser($userId) {
    global $conn;
    $sql = "SELECT * FROM Users WHERE user_id='$userId'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return null;
    }
}

// Delete a user from the database
function deleteUser($userId) {
    global $conn;
    $sql = "DELETE FROM Users WHERE user_id='$userId'";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Check if the request is for getUsers
if (isset($_GET['action']) && $_GET['action'] == 'getUsers') {
    $users = getUsers();
    echo json_encode($users);
    exit();
}

// Check if the request is for addUser
if (isset($_POST['action']) && $_POST['action'] == 'addUser') {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $contactNumber = $_POST['contactNumber'];
    $location = $_POST['location'];
    $vehicleType = $_POST['vehicleType'];
    $entryTime = $_POST['entryTime'];
    $exitTime = $_POST['exitTime'];
    $role = $_POST['role'];

    $success = addUser($fullName, $email, $password, $contactNumber, $location, $vehicleType, $entryTime, $exitTime, $role);
    if ($success) {
        echo "User added successfully!";
    } else {
        echo "Error adding user.";
    }
    exit();
}

// Check if the request is for editUser
if (isset($_POST['action']) && $_POST['action'] == 'editUser') {
    $userId = $_POST['userId'];
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $contactNumber = $_POST['contactNumber'];
    $location = $_POST['location'];
    $vehicleType = $_POST['vehicleType'];
    $entryTime = $_POST['entryTime'];
    $exitTime = $_POST['exitTime'];
    $role = $_POST['role'];

    $success = editUser($userId, $fullName, $email, $password, $contactNumber, $location, $vehicleType, $entryTime, $exitTime, $role);
    if ($success) {
        echo "User updated successfully!";
    } else {
        echo "Error updating user.";
    }
    exit();
}

// Check if the request is for deleteUser
if (isset($_POST['action']) && $_POST['action'] == 'deleteUser') {
    $userId = $_POST['userId'];

    $success = deleteUser($userId);
    if ($success) {
        echo "User deleted successfully!";
    } else {
        echo "Error deleting user.";
    }
    exit();
}



$conn->close();
?>