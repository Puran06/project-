<?php
session_start();

if (isset($_POST['new_password'])) {
    // Validate and sanitize input data here if needed

    // Update the user's password in the database
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "vpmsdd";

    $connection = mysqli_connect($host, $username, $password, $database);

    if ($connection) {
        $email = $_SESSION['email'];
        $newPassword = password_hash(mysqli_real_escape_string($connection, $_POST['new_password']), PASSWORD_DEFAULT);

        $query = "UPDATE Users SET password='$newPassword' WHERE email='$email'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            // Password change successful
            echo "Password changed successfully!";
        } else {
            // Password change failed
            echo "Password change failed.";
        }

        mysqli_close($connection);
    } else {
        echo "Database connection failed.";
    }
} else {
    echo "Invalid data.";
}
?>
