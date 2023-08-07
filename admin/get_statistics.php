<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vpmsdd";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = array();

// Total Users
$queryUsers = "SELECT COUNT(*) AS totalUsers FROM Users";
$resultUsers = $conn->query($queryUsers);
if ($resultUsers !== false && $resultUsers->num_rows > 0) {
    $rowUsers = $resultUsers->fetch_assoc();
    $data['totalUsers'] = $rowUsers['totalUsers'];
}

// Total Admins
$queryAdmins = "SELECT COUNT(*) AS totalAdmins FROM Users WHERE role = 'admin'";
$resultAdmins = $conn->query($queryAdmins);
if ($resultAdmins !== false && $resultAdmins->num_rows > 0) {
    $rowAdmins = $resultAdmins->fetch_assoc();
    $data['totalAdmins'] = $rowAdmins['totalAdmins'];
}

// Total Vehicles Parked
$queryVehicles = "SELECT COUNT(*) AS totalVehicles FROM Users WHERE vehicle_type IS NOT NULL";
$resultVehicles = $conn->query($queryVehicles);
if ($resultVehicles !== false && $resultVehicles->num_rows > 0) {
    $rowVehicles = $resultVehicles->fetch_assoc();
    $data['totalVehicles'] = $rowVehicles['totalVehicles'];
}

// Total Locations Used
$queryLocations = "SELECT COUNT(DISTINCT location) AS totalLocations FROM Users";
$resultLocations = $conn->query($queryLocations);
if ($resultLocations !== false && $resultLocations->num_rows > 0) {
    $rowLocations = $resultLocations->fetch_assoc();
    $data['totalLocations'] = $rowLocations['totalLocations'];
}

// Total Bookings
$queryBookings = "SELECT COUNT(*) AS totalBookings FROM Users WHERE entry_time IS NOT NULL";
$resultBookings = $conn->query($queryBookings);
if ($resultBookings !== false && $resultBookings->num_rows > 0) {
    $rowBookings = $resultBookings->fetch_assoc();
    $data['totalBookings'] = $rowBookings['totalBookings'];
}

$conn->close();

echo json_encode($data);
?>
