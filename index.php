<?php
<<<<<<< work
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];
	header('Location: '.$uri.'/dashboard/');
	exit;
?>
Something is wrong with the XAMPP installation :-(
=======
$servername = "localhost";
$username = "root";
$password = "";
$database_name = "studentdetail";




$conn = mysqli_connect($servername, $username, $password, $database_name);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

if (isset($_POST['saves'])) {
    $studentID = $_POST['studentID"'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phonenumber = $_POST['phoneNumber'];
    $emailaddress = $_POST['emailaddress'];
    $shuttleID = $_POST['shuttleID'];



    $sql_query = "INSERT INTO student_detail (studentID, firstName, lastName, phonenumber, emailaddress, shuttleID)
                  VALUES('$studentID', '$firstName', '$lastName', '$phoneNumber', '$emailaddress', '$shuttleID')";

    if (mysqli_query($conn, $sql_query)) {
        echo "New details entered successfully";
    } else {
        echo "Error: " . $sql_query . " " . mysqli_error($conn);
    }
} else {
    echo "All fields are required.";
}

mysqli_close($conn);
>>>>>>> main
