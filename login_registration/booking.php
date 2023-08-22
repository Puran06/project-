<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // User is not logged in, redirect to the login page
    header("Location: ../users/login.html");
    exit();
}

// Database connection parameters
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $location = $_POST["location"];
    $vehicle_type = $_POST["vehicle_type"];
    $entry_time = $_POST["entry_time"];
    $exit_time = $_POST["exit_time"];

    // Validate and sanitize the data (You should perform more thorough validation as per your requirements)
    $location = htmlspecialchars($location);
    $vehicle_type = htmlspecialchars($vehicle_type);
    $entry_time = htmlspecialchars($entry_time);
    $exit_time = htmlspecialchars($exit_time);

    // Calculate the duration in hours
    $entry_datetime = new DateTime($entry_time);
    $exit_datetime = new DateTime($exit_time);
    $duration = $exit_datetime->diff($entry_datetime);
    $duration_in_hours = $duration->h + ($duration->days * 24);

    // Total number of vehicle parking options and total locations
$total_vehicle_options = 4;
$total_locations = 4;

    // Calculate the total money based on the vehicle type
    $rate_per_hour = 0;
    switch ($vehicle_type) {
        case 'Bike':
            $rate_per_hour = 10;
            break;
        case 'Car':
            $rate_per_hour = 20;
            break;
        case 'Bus':
            $rate_per_hour = 30;
            break;
        case 'Truck':
            $rate_per_hour = 50;
            break;
        default:
            // Handle invalid vehicle type (optional)
            break;
    }

    $total_money = $duration_in_hours * $rate_per_hour;

    // Retrieve the logged-in user's email from the session
    $email = $_SESSION['email'];

    // Prepare the SQL statement to update the booking data in the Users table
    $query = "UPDATE Users SET location = '$location', vehicle_type = '$vehicle_type', entry_time = '$entry_time', exit_time = '$exit_time', total_money = '$total_money' WHERE email = '$email'";

    // Execute the query to update the booking data
    if (mysqli_query($connection, $query)) {
        // Booking information updated successfully, you can redirect the user to the dashboard
        header("Location: user_dashboard.php");
        exit();
    } else {
        // Handle the error if the booking data update fails
        echo "Error: " . mysqli_error($connection);
    }
}

// Total number of vehicle parking options and total locations
$total_vehicle_options = 4;
$total_locations = 4;

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Parking Booking</title>
    <link rel="stylesheet" href="userbooking.css">
</head>
<body>

<h1>Vehicle Parking Booking</h1>

    <div>
        <nav>
            <ul>
                <li><a href="user_dashboard.php">my-page</a> </li>
            </ul>
        </nav>
    </div>
    
    

    <div id ="statistics">
           <p>Total number of vehicle parking options: <?php echo $total_vehicle_options; ?></p>
           <p>Total number of locations: <?php echo $total_locations; ?></p>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="location">Select Location:</label>
        <select name="location" id="location" required>
            <option value="">Select Location</option>
            <option value="Location 1">Location 1</option>
            <option value="Location 2">Location 2</option>
            <option value="Location 3">Location 3</option>
            <option value="Location 4">Location 4</option>
        </select>
        <br>
        <label for="vehicle_type">Select Vehicle Type:</label>
        <select name="vehicle_type" id="vehicle_type" required>
            <option value="">Select Vehicle Type</option>
            <option value="Bike">Bike</option>
            <option value="Car">Car</option>
            <option value="Bus">Bus</option>
            <option value="Truck">Truck</option>
        </select>
        <br>
        <label for="entry_time">Entry Time:</label>
        <input type="datetime-local" name="entry_time" id="entry_time" required>
        <br>
        <label for="exit_time">Exit Time:</label>
        <input type="datetime-local" name="exit_time" id="exit_time" required>
        <br>
        <button type="submit">Book Now</button>
    </form>

    <?php
    if (isset($total_money)) {
        echo "<p>Total Money: Rs " . $total_money . "</p>";
    }
    ?>

</body>
</html>
