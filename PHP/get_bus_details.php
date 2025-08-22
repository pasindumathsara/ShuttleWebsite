<?php
$servername = "localhost";
$username = "root";
$password = "";
$database_name = "shuttle_link";

$conn = mysqli_connect($servername, $username, $password, $database_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['busNumber'])) {
    $busNumber = $_GET['busNumber'];

    // SQL query to retrieve data for the selected bus
    $sql = "SELECT Bus_Number, Driver_name, Id_no, Departure_time, Arrival_time, booked_seats, price 
            FROM shuttle_details WHERE Bus_Number = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $busNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();

    if ($result->num_rows > 0) {
        // Fetch data into an array
        $data = $result->fetch_assoc();
    } else {
        echo json_encode(array("error" => "No data found for the selected bus."));
    }

    echo json_encode($data); // Return data as JSON
    $stmt->close();
} else {
    echo json_encode(array("error" => "Bus number not provided."));
}

$conn->close();
?>
