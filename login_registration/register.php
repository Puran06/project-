<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $contactNumber = $_POST["contact_number"];
    $role = $_POST["role"];

    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $db_password = "";
    $dbname = "vpmsdd";

    $conn = new mysqli($servername, $username, $db_password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, contact_number, role)
                           VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $password, $contactNumber, $role);

    if ($stmt->execute()) {
        // Registration successful
        echo "Registration successful!";
        // Perform further actions as needed
    } else {
        // Registration failed
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
