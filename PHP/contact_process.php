<?php
$servername = "localhost";
$username = "root";
$password = "";
$database_name = "shuttle_link";


$conn = mysqli_connect($servername, $username, $password, $database_name);


if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}


if (isset($_POST['Send'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $message = $_POST['message'];

  
    $sql_query = "INSERT INTO contact_page (Name, Email_address, Phone_Number, Message) 
                  VALUES('$name', '$email', '$phone_number', '$message')";

    if (mysqli_query($conn, $sql_query)) {
       
        echo "<script>
                alert('Message successfully sent! Admins will contact you soon.');
                window.setTimeout(function(){
                    window.location.href = '../homepage.html';
                }, 3000);
              </script>";
    } else {
        echo "Error: " . $sql_query . " " . mysqli_error($conn);
    }
} else {
    echo "<script>alert('All fields are required.');</script>";
}


mysqli_close($conn);
?>
