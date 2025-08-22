<?php
session_start(); 

include 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_email = $_POST['username_email'];
    $password = $_POST['password']; 

   
    $query = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username_email, $username_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
       
        if (password_verify($password, $user['password'])) {
           
            $_SESSION['user_id'] = $user['id']; 
            $_SESSION['username'] = $user['username'];
            
          
            header("Location: StudentProfile.php");
            exit();
        } else {
            echo "Invalid password."; 
        }
    } else {
        echo "No user found with that username or email.";
    }

    $stmt->close();
    $conn->close();
}
?>
