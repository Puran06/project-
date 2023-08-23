<?php
session_start();

if (isset($_POST['full_name']) && isset($_POST['contact_number']) && isset($_POST['location'])) {
    // Validate and sanitize input data here if needed

    // Update the user's profile in the database
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "vpmsdd";

    $connection = mysqli_connect($host, $username, $password, $database);

    if ($connection) {
        $email = $_SESSION['email'];
        $fullName = mysqli_real_escape_string($connection, $_POST['full_name']);
        $contactNumber = mysqli_real_escape_string($connection, $_POST['contact_number']);
        $location = mysqli_real_escape_string($connection, $_POST['location']);

        $query = "UPDATE Users SET full_name='$fullName', contact_number='$contactNumber', location='$location' WHERE email='$email'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            // Profile update successful
            echo "Profile updated successfully!";
        } else {
            // Profile update failed
            echo "Profile update failed.";
        }

        mysqli_close($connection);
    } else {
        echo "Database connection failed.";
    }
} else {
    echo "Invalid data.";
}
?>
