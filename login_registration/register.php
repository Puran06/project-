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
    $password = "";
    $dbname = "vpmsdd";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert new user into the database
    $sql = "INSERT INTO users (full_name, email, password, contact_number, role)
            VALUES ('$name', '$email', '$password', '$contactNumber', '$role')";

    if ($conn->query($sql) === TRUE) {
        // Registration successful
        echo "Registration successful!";
        // Perform further actions as needed
    } else {
        // Registration failed
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
