<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate the data (e.g., check if the email and password meet certain requirements)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit();
    }

    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $db_password = "";
    $dbname = "vpmsdd";

    $conn = new mysqli($servername, $username, $db_password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the SQL statement to prevent SQL injection
    $query = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, get their role from the database
        $row = $result->fetch_assoc();
        $role = $row['role'];

        // Perform role-based redirection
        if ($role === 'admin') {
            // User is an admin, redirect to admin_dashboard.php
            header("Location: ../admin/user_management.html");
            exit();
        } elseif ($role === 'user') {
            // User is a regular user, redirect to user_dashboard.php
            $_SESSION['email'] = $email; // Set session variable
            header("Location: user_dashboard.php");
            exit();
        } else {
            // Invalid role, handle the error
            echo "Invalid role";
            exit();
        }
    } else {
        // User doesn't exist or provided incorrect credentials
        // Show a message in a prompt and redirect to login_registration.php
        echo "<script>alert('Invalid email or password. Please try again.'); window.location.href = 'login_registration.php';</script>";
        exit();
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect to the login form if accessed directly without form submission
    header("Location: ../users/login.html");
    exit();
}
?>
