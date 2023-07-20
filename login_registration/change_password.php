<?php
// change_password.php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // User is not logged in, redirect or handle the error
    $response = array('success' => false, 'message' => 'User not logged in');
    echo json_encode($response);
    exit();
}

// Retrieve the new password from the AJAX request
$newPassword = $_POST['password'] ?? '';

// Validate the new password (perform any necessary checks/validation)

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

// Prepare the SQL statement to update the user's password
$query = "UPDATE Users SET password = ? WHERE email = ?";
$stmt = mysqli_prepare($connection, $query);

// Hash the new password before storing it in the database
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// Bind the parameters and execute the statement
mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $email);
$result = mysqli_stmt_execute($stmt);

// Check if the update was successful
if ($result) {
    $response = array('success' => true, 'message' => 'Password changed successfully');
    echo json_encode($response);
} else {
    $response = array('success' => false, 'message' => 'Failed to change password');
    echo json_encode($response);
}

// Close the statement and database connection
mysqli_stmt_close($stmt);
mysqli_close($connection);
?>
