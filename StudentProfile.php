<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$database = "bus_booking_system";

$conn = new mysqli($host, $user, $password, $database);

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch user data from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_image'])) {
    // Image upload handling
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
    
    if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
        $sql = "UPDATE users SET profile_image='$target_file' WHERE id='$user_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Profile image updated!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
</head>
<body>
    <h2>Your Profile</h2>
    <p>Email: <?php echo $user['email']; ?></p>
    <p>Phone: <?php echo $user['phone']; ?></p>
    <p>Student ID: <?php echo $user['student_id']; ?></p>
    <p>Profile Image: <img src="<?php echo $user['profile_image']; ?>" width="100"></p>

    <h3>Upload Profile Image</h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="profile_image" required><br>
        <input type="submit" value="Upload">
    </form>

    <form method="POST" action="logout.php">
        <input type="submit" value="Logout">
    </form>
</body>
</html>
