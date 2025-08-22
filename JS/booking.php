<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shuttle_link";

// Create connection
try
$conn =  mysql($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define variables and initialize with empty values
$bus = $from_where = $from_to = $how_date = "";
$bus_err = $from_where_err = $from_to_err = $how_date_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate bus selection
    if (empty(trim($_POST["bus"]))) {
        $bus_err = "Please select a shuttle.";
    } else {
        $bus = trim($_POST["bus"]);
    }

    // Validate departure
    if (empty(trim($_POST["from_where"]))) {
        $from_where_err = "Please enter departure location.";
    } else {
        $from_where = trim($_POST["from_where"]);
    }

    // Validate destination
    if (empty(trim($_POST["from_to"]))) {
        $from_to_err = "Please enter destination.";
    } else {
        $from_to = trim($_POST["from_to"]);
    }

    // Validate date
    if (empty(trim($_POST["how_date"]))) {
        $how_date_err = "Please select a travel date.";
    } else {
        $how_date = trim($_POST["how_date"]);
    }

    // Check input errors before inserting in database
    if (empty($bus_err) && empty($from_where_err) && empty($from_to_err) && empty($how_date_err)) {
        $sql = "INSERT INTO booking (Shuttle_service, from_where, from_to, how_date) VALUES (?, ?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssss", $bus, $from_where, $from_to, $how_date);
            if ($stmt->execute()) {
                echo "Ticket booked successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "Errors: ";
        echo $bus_err . " " . $from_where_err . " " . $from_to_err . " " . $how_date_err;
    }

    $conn->close();
}




?>
