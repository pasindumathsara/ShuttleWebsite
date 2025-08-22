<?php
session_start();
include 'config.php'; // Include your database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: loginpage.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get the latest ticket for the logged-in user
$query = "SELECT * FROM tickets WHERE user_id = ? ORDER BY purchase_date DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$ticket = $result->fetch_assoc();

if (!$ticket) {
    echo "<h2>No ticket found. Please purchase a ticket first.</h2>";
    exit();
}

$ticket_number = $ticket['ticket_number'];
$qr_code = $ticket['qr_code'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Purchase Successful</title>
    <link rel="stylesheet" href="CSS/ticket_success.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            padding: 20px;
            text-align: center;
        }
        .container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        h1 {
            color: #28a745;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #218838;
        }
        .qr-code {
            margin: 20px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Ticket Purchase Successful!</h1>
    <p>Your ticket number is: <strong><?php echo htmlspecialchars($ticket_number); ?></strong></p>
    <p>Thank you for your purchase! You can download your ticket using the button below:</p>
    
    <a href="download_ticket.php?ticket_number=<?php echo urlencode($ticket_number); ?>" class="button">
        Download Ticket
    </a>

    <div class="qr-code">
        <h2>Your QR Code:</h2>
        <img src="<?php echo htmlspecialchars($qr_code); ?>" alt="QR Code" style="width: 200px; height: 200px;">
        <p>You can download the QR code by clicking the button below:</p>
        <a href="<?php echo htmlspecialchars($qr_code); ?>" class="button" download>Download QR Code</a>
    </div>
</div>

</body>
</html>
