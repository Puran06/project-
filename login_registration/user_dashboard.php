<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // User is not logged in, redirect to the login page
    header("Location: ../users/login.html");
    exit();
}

$host = "localhost"; // replace with your database host
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$database = "vpmsdd"; // replace with your database name

// Create a database connection
$connection = mysqli_connect($host, $username, $password, $database);

// Check if the connection is successful
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Retrieve the logged-in user's email from the session
$email = $_SESSION['email'];

// Prepare the SQL statement to retrieve user data based on the email
$query = "SELECT * FROM Users WHERE email = '$email'";

// Execute the query
$result = mysqli_query($connection, $query);

// Check if a row is returned (user exists)
if (mysqli_num_rows($result) == 1) {
    // Fetch the user data
    $row = mysqli_fetch_assoc($result);

    // Assign the user data to variables
    $full_name = $row['full_name'];
    $email = $row['email'];
    $contact_number = $row['contact_number'];
    $location = $row['location'];
    $vehicle_type = $row['vehicle_type'];
    $entry_time = $row['entry_time'];
    $exit_time = $row['exit_time'];
    $total_money = $row['total_money'];
    $user_id = $row['user_id'];
    $role = $row['role'];
} else {
    // User not found, handle the error or redirect to the login page
}

// Free the result set
mysqli_free_result($result);

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="users_dashboard.css">
</head>
<body>
    <h1>Welcome to your User Dashboard</h1>
    <nav>
        <div class="container">
            <a class="logo" href="#">Logo</a>
            <ul class="navbar-menu">
                <li><a href="../index.html">Home</a></li>
                <!-- Add Booking Link -->
                <li><a href="booking.php">Booking</a></li>
            </ul>
        </div>
    </nav>

    <div class="profile-section">
        <h2>User Profile</h2>
        <p><strong>Full Name:</strong> <span id="full-name"><?= $full_name ?></span></p>
        <p><strong>Email:</strong> <span id="email"><?= $email ?></span></p>
        <p><strong>Contact Number:</strong> <span id="contact-number"><?= $contact_number ?></span></p>
        <p><strong>Location:</strong> <span id="location"><?= $location ?></span></p>
        <p><strong>Vehicle Type:</strong> <span id="vehicle-type"><?= $vehicle_type ?></span></p>
        <p><strong>Entry Time:</strong> <span id="entry-time"><?= $entry_time ?></span></p>
        <p><strong>Exit Time:</strong> <span id="exit-time"><?= $exit_time ?></span></p>
        <p><strong>Total Money:</strong> <span id="total-money"><?= $total_money ?></span></p>
    </div>

    <div class="account-section">
        <h2>Account Details</h2>
        <p><strong>User ID:</strong> <span id="user-id"><?= $user_id ?></span></p>
        <p><strong>Role:</strong> <span id="role"><?= $role ?></span></p>
    </div>

    <div class="activity-section">
        <h2>Recent Activity</h2>
        <p><strong>Latest Entry Time:</strong> <span id="latest-entry-time"><?= $entry_time ?></span></p>
        <p><strong>Latest Exit Time:</strong> <span id="latest-exit-time"><?= $exit_time ?></span></p>
        <p><strong>Latest Total Money Spent:</strong> <span id="latest-total-money"><?= $total_money ?></span></p>
    </div>

    <div class="actions-section">
        <h2>Actions</h2>
        <button onclick="updateProfile()">Update Profile</button>
        <button onclick="changePassword()">Change Password</button>

        <button><a href="login_registration.php">logout</a></button>
    </div>

    <script src="users_dashboard.js"></script>
</body>
</html>
