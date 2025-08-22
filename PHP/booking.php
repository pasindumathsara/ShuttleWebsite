 <?php
session_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$database_name = "shuttle_link";


if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('You should log in first before booking.');
            window.location.href = '../studentlogin.html';
          </script>";
    exit;
}


$conn = mysqli_connect($servername, $username, $password, $database_name);
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}


$user_id = $_SESSION['user_id']; 
$ticket_number = strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));

if (isset($_POST['saves'])) {
   
    if (!empty($_POST['Shuttle_id']) && !empty($_POST['start_point']) && !empty($_POST['end_point']) && !empty($_POST['date'])) {
       
        $Shuttle_id = $_POST['Shuttle_id'];
        $start_point = $_POST['start_point'];
        $end_point = $_POST['end_point'];
        $date = $_POST['date'];

      
        $sql_query = "INSERT INTO booking_ticket (user_id, Shuttle_id, start_point, end_point, month, ticket_number) 
                      VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_query);
        $stmt->bind_param("isssss", $user_id, $Shuttle_id, $start_point, $end_point, $date, $ticket_number); 

       
        if ($stmt->execute()) {
           
            header("Location: ../book_ticket_step_02.html");
            exit();
        } else {
            
            echo "Error: " . $sql_query . " " . $stmt->error;
        }

       
        $stmt->close();
    } else {
       
        echo "All fields are required.";
    }
} else {
    echo "Form not submitted.";
}


mysqli_close($conn);
?>
