<?php
session_start();
include 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); 

  
    $query = "INSERT INTO users (name, student_id, email, phone_number, username, password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssss", $name, $student_id, $email, $phone_number, $username, $hashed_password);
    
    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id; 
        header("Location: ../privacy policy.html"); 
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
