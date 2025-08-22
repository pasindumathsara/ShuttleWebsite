<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database_name = "shuttle_link";
include 'config.php'; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}



$conn = mysqli_connect($servername, $username, $password, $database_name);                                                                                                                  

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve data
$sql = "SELECT Bus_Number, Driver_name,Id_no, Departure_time, Arrival_time, booked_seats, price FROM shuttle_details";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    // Fetch data into an array
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo json_encode($data); // Return empty array if no results
}
$conn->close();

// Return data as JSON
echo json_encode($data);
?>
