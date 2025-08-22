<?php
$servername = "localhost";
$username = "root";
$password = "";
$database_name = "shuttle_link";


$conn = mysqli_connect($servername, $username, $password, $database_name);       

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$cardholder_name = $_POST['cardholder-name'];
$card_number = $_POST['card-number'];
$expiry_date = $_POST['expiry-date'];
$cvv = $_POST['cvv'];

// SQL query to insert data
$sql = "INSERT INTO payment_details (holders_name,card_number,exp_date,cvv) 
        VALUES ('$cardholder_name', '$card_number', '$expiry_date', '$cvv')";

if ($conn->query($sql) === TRUE) {
    echo "Payment recorded successfully!";
    header("Location: ../verify_payment.html");  // Redirect to payment verification page
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
