<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studentdetail";

// Create connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET["id"];
    $sql = "SELECT * FROM details WHERE StudentID = $id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        echo "Student not found.";
        exit();
    }

    $firstName = $row['FirstName'];
    $lastName = $row['LastName'];
    $phoneNumber = $row['PhoneNumber'];
    $emailAddress = $row['EmailAddress'];
    $routeID = $row['RouteID'];
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $phoneNumber = $_POST["phoneNumber"];
    $emailAddress = $_POST["emailAddress"];
    $routeID = $_POST["routeID"];

    $sql = "UPDATE details SET FirstName = '$firstName', LastName = '$lastName', PhoneNumber = '$phoneNumber', EmailAddress = '$emailAddress', RouteID = '$routeID' WHERE StudentID = $id";

    if ($connection->query($sql) === TRUE) {
        header("Location: /index.php");
        exit();
    } else {
        echo "Error updating record: " . $connection->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
        }
        .container h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 4px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            text-align: center;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Student Details</h1>
        <form action="edit.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>">
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" value="<?php echo $lastName; ?>">
            </div>
            <div class="form-group">
                <label for="phoneNumber">Phone Number</label>
                <input type="text" id="phoneNumber" name="phoneNumber" value="<?php echo $phoneNumber; ?>">
            </div>
            <div class="form-group">
                <label for="emailAddress">Email Address</label>
                <input type="email" id="emailAddress" name="emailAddress" value="<?php echo $emailAddress; ?>">
            </div>
            <div class="form-group">
                <label for="routeID">Shuttle ID</label>
                <input type="text" id="routeID" name="routeID" value="<?php echo $routeID; ?>">
            </div>
            <button type="submit" class="btn">Update</button>
        </form>
    </div>
</body>
</html
