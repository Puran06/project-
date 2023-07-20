<?php
// update_profile.php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // User is not logged in, send an error response
    $response = array('success' => false, 'message' => 'User not logged in');
    echo json_encode($response);
    exit();
}

// Retrieve the updated profile data from the AJAX request
$updatedFullName = $_POST['full_name'] ?? '';
$updatedContactNumber = $_POST['contact_number'] ?? '';
$updatedLocation = $_POST['location'] ?? '';
$updatedVehicleType = $_POST['vehicle_type'] ?? '';

// Validate the updated data (perform any necessary checks/validation)

// Connect to the database
$host = "localhost"; // replace with your database host
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$database = "vpmsdd"; // replace with your database name

$connection = mysqli_connect($host, $username, $password, $database);

// Check if the connection is successful
if (!$connection) {
    $response = array('success' => false, 'message' => 'Database connection failed');
    echo json_encode($response);
    exit();
}

// Retrieve the logged-in user's email from the session
$email = $_SESSION['email'];

// Prepare the SQL statement to update the user's profile data
$query = "UPDATE Users SET full_name = ?, contact_number = ?, location = ?, vehicle_type = ? WHERE email = ?";
$stmt = mysqli_prepare($connection, $query);

if ($stmt) {
    // Bind the parameters and execute the statement
    mysqli_stmt_bind_param($stmt, "sssss", $updatedFullName, $updatedContactNumber, $updatedLocation, $updatedVehicleType, $email);
    $result = mysqli_stmt_execute($stmt);

    // Check if the update was successful
    if ($result) {
        $response = array('success' => true, 'message' => 'Profile updated successfully');
        echo json_encode($response);
    } else {
        $response = array('success' => false, 'message' => 'Failed to update profile');
        echo json_encode($response);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Failed to prepare the statement, send an error response
    $response = array('success' => false, 'message' => 'Failed to prepare the update statement');
    echo json_encode($response);
}

// Close the database connection
mysqli_close($connection);
?>
