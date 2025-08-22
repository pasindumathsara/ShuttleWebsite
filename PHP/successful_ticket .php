<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database_name = "shuttle_link";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect if the user is not logged in
    exit;
}

// Get the most recent ticket details
$conn = mysqli_connect($servername, $username, $password, $database_name);

if (!$conn) {   
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id']; // Assuming the user ID is stored in the session

// SQL query to fetch the latest ticket for the user
$sql = "SELECT Shuttle_id, start_point, end_point, month, ticket_number FROM booking_ticket WHERE user_id = '$user_id' ORDER BY booking_id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result && mysqli_num_rows($result) > 0) {
    $ticket = mysqli_fetch_assoc($result);
} else {
    // Handle case where no ticket is found
    $ticket = [
        'Shuttle_id' => 'N/A',
        'start_point' => 'N/A',
        'end_point' => 'N/A',
        'month' => 'N/A',
        'ticket_number' => 'N/A' // Add ticket_number to avoid undefined variable error
    ];
}

mysqli_close($conn);
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
            font-family: 'Arial', sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
            max-width: 600px;
        }

        .container h2 {
            color: #28a745;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .ticket-info {
            text-align: left;
            font-size: 18px;
            color: #333;
        }

        .ticket-info p {
            margin: 10px 0;
        }

        .ticket-info strong {
            color: #007bff;
        }

        .btn-container {
            margin-top: 30px;
        }

        .btn-container button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-container button:hover {
            background-color: #0056b3;
        }

        .footer {
            margin-top: 30px;
        }

        .footer p {
            color: #777;
            font-size: 14px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
</head>
<body>

<div class="container">
    <h2>You booked your ticket successfully!</h2>
    <p>Thank you for booking your shuttle. Below are the details of your ticket:</p>

    <div class="ticket-info" style="position:relative; left:50px; top:60px">
        <p><strong>Ticket Number:</strong> <?php echo $ticket['ticket_number']; ?></p> <!-- Display the random ticket number -->
        <p><strong>Shuttle ID:</strong> <?php echo $ticket['Shuttle_id']; ?></p>
        <p><strong>From:</strong> <?php echo $ticket['start_point']; ?></p>
        <p><strong>To:</strong> <?php echo $ticket['end_point']; ?></p>
        <p><strong>Date:</strong> <?php echo $ticket['month']; ?></p>
    </div>

    <div id="qrcode" style="position:relative; left:150px; top:-80px"></div>

    <div class="btn-container" style="position:relative; top:-60px; left:10px">
        <button onclick="window.print()">Print Ticket</button>
        <button onclick="location.href='StudentProfile.php'">Back to Profile</button>
    </div>

    <div class="footer">
        <p>&copy; 2024 Shuttle Booking System. All rights reserved.</p>
    </div>
</div>

<script>
    $(document).ready(function() {
        var textToEncode = "Ticket Number: <?php echo $ticket['ticket_number']; ?>"; // Encode the ticket number in the QR code
        
        // Set QR code size (width and height)
        var qrCodeSize = 150; // Size in pixels

        $('#qrcode').qrcode({
            text: textToEncode,
            width: qrCodeSize,
            height: qrCodeSize
        });
    });
</script>
</body>
</html>
