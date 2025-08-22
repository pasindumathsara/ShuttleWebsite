<?php
session_start();
include 'config.php'; 


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit;
}


$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_photo'])) {
    $file = $_FILES['profile_photo'];

    
    if ($file['error'] == 0) {
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];

        if (in_array($fileExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 5000000) { 
                    $newFileName = "profile_" . $user_id . "." . $fileExt;
                    $fileDestination = 'uploads/profile_pictures/' . $newFileName;

                  
                    move_uploaded_file($fileTmpName, $fileDestination);

                    
                    $updateQuery = "UPDATE users SET profile_picture = ? WHERE id = ?";
                    $updateStmt = $conn->prepare($updateQuery);
                    $updateStmt->bind_param("si", $fileDestination, $user_id);
                    $updateStmt->execute();

                    header("Location: StudentProfile.php");
                } else {
                    echo "Your file is too large.";
                }
            } else {
                echo "There was an error uploading your file.";
            }
        } else {
            echo "You cannot upload files of this type.";
        }
    }
}


$payment_query = "SELECT * FROM booking_ticket WHERE user_id = ?";
$payment_stmt = $conn->prepare($payment_query);
$payment_stmt->bind_param("i", $user_id);
$payment_stmt->execute();
$payment_result = $payment_stmt->get_result();

$payments = [];
while ($payment = $payment_result->fetch_assoc()) {
    $payments[] = $payment;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Shuttle Service Profile</title>
    <link rel="stylesheet" href="Profiles.css"> 
    <style>
         footer {
            background-color: #1b3e54;
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
            bottom: 0;
            width: 100%;
            top:95      px;
        }

        .footer-links {
            margin-top: 10px;
        }

        .footer-links a {
            color: #c6d1da;
            margin: 0 10px;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: #ffa500; /* Darker gold on hover */
        }

       
        .navbar {
    display: flex;
    flex-direction: column;
    background-color:#1b3e54;
    opacity: 0.9;
    padding: 0;
    color: white;
    position: relative; /* Change this from fixed to relative */
    width: 100%; /* Full width */
}
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px; /* Adjusted padding */
            height: 80px;
        }

        .search-container {
            display: flex;
            align-items: center;
            margin-right: 10px;
            flex: 1;
            position: relative; 
        }

        #searchBar {
            width: 500px; /* Adjusted width */
            padding: 10px;
            background-color: #ddd;
            border: none;
            border-radius: 5px;
            margin-right: 10px; 
        }

        .search-icon {
            background: url('icons8-search-50.png') no-repeat center;
            width: 24px;
            height: 24px;
            cursor: pointer;
            position: absolute;
            right: 10px; 
        }

        #profileButton {
            display: flex;
            align-items: center;
            padding: 10px;
            background-color: #555;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #profileButton .profile-icon {
            width: 20px;
            height: 20px;
            margin-right: 5px;
        }

        .bottom-bar {
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            width: 100%; /* Full width */
            background-color:#1b3e54;
        }

        .bottom-bar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
        }
        .top-bar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
        }

        .bottom-bar a:hover {
            background-color: #555;
        }

        #eventList {
            padding: 20px;
            display: none;
            position: relative;
            width: 400px;
            background: transparent;
        }

        .event-item {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
        }

        @media screen and (max-width: 768px) {
            .top-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .search-container {
                margin: 10px 0;
            }

            #searchBar {
                width: 100%; /* Full width in smaller screens */
                margin-right: 0; /* No right margin */
            }

            .search-icon {
                margin-left: 0; /* Adjusted for smaller screens */
                right: 10px;
            }

            #profileButton {
                justify-content: center;
                margin-top: 10px; /* Added margin */
            }
        }

        .line{
            position: relative;
            left: 770px;
        }
    </style>
</head>
<body>


 <div class="navbar">
        <div class="top-bar">
            <img src="../Images/iconss.jpg" alt="" width="120px" height="90px" style="position:relative; top: 2px;left: -300px; border-radius:5px">
            
            <div class="search-container" style="position: relative;left: -220px;" >
                <input type="text" id="searchBar" placeholder="Search events..." onclick="toggleEventList()" oninput="filterEvents()">
                <div class="search-icon"></div>
                <img src="../Images/icons8-search-50.png" alt="" style="position: relative; width: 28px; height: 28px; left: -50px;">
            </div>
            <img src="../Images/admin3.jpg" alt="" style="position: relative; width: 40px; height: 40px; left: 330px;">
            <a href="StudentProfile.php" style="position: relative;left: 330px;">My Profile</a>
            
                
        </div>
        <div class="bottom-bar">
            <a href="../homepage.html"style="position: relative;left: 290px;">Home</a>
            <a href="New_Catergory.html"style="position: relative;left: 120px;">Ticket</a>
            <a href="event.html"style="position: relative;left: -50px;">Roots</a>
            <a href=""style="position: relative;left: -220px;">Contact Us</a>
            <button class="profile-btn" onclick="window.location.href='logout.php'" style="background-color:#1b3e54; position:relative;width:00px; font-size:16px;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
           
        </div>
    </div>
<div style="position: relative;">
<div class="slider">
    <div class="slides">
        <img src="../Images/bus3.jpg" alt="Image 1">
        <img src="../Images/bus5.webp" alt="Image 2">
        <img src="../Images/bus4.webp" alt="Image 3">
        <img src="../Images/bus5.webp" alt="Image 4">
    </div>
</div>

<script>
    const slides = document.querySelector('.slides');
    const images = slides.querySelectorAll('img');
    const totalImages = images.length;
    let currentIndex = 0;

    function showNextImage() {
        currentIndex++;
        if (currentIndex >= totalImages) {
            currentIndex = 0;
        }
        const offset = -currentIndex * 100;
        slides.style.transform = `translateX(${offset}%)`;
    }

    setInterval(showNextImage, 3000);
</script>

<div class="profile-container">
    <div class="profile-header">
        <img src="../<?= htmlspecialchars($user['profile_picture']) ?>" alt="Profile Picture" id="profile-picture" onerror="this.src='default.jpg';">
        <div class="student-info" style="position:relative; left:-250px">
            <h1 style="font-size: 20px;">Sachini Umayangana</h1>
            <p style="color: white;">ID: <?= htmlspecialchars($user['student_id']) ?></p>
            <p style="color: white;">Email: <?= htmlspecialchars($user['email']) ?></p>
            <p style="color: white;">Phone: <?= htmlspecialchars($user['phone_number']) ?></p>
            <form method="POST" enctype="multipart/form-data"style="position:relative; top: 30px;">
                <label for="file-upload" class="edit-photo" style="text-decoration: none; color: white;">Edit Profile Photo</label>
                <input type="file" id="file-upload" name="profile_photo" accept="image/*" onchange="previewImage(event)">
                <br>
                <button type="submit" style="background-color:#1584a2;">Update Profile</button>
            </form>
            <br>
            <a href="../QR-Code.html" class="QR-button" style="background-color:#1584a2; position:relative; left:500px">Download QR Code</a>
            <a href="../book_ticket.html" class="QR-button" style="background-color: #1584a2; position:relative; left:180px">Book Ticket</a>
           
        </div>
    </div>

    <div class="line"></div>

    <div class="section1" style="position:absolute;top:190px">
        <h3>Shuttle Service Details</h3>
        <p>Route: Cinec Campus to Kiribathgoda</p>
        <p>Timing: 8:00 AM - 8:30 AM</p>
    </div>

    <div class="section">
        <h2>Notifications</h2>
        <div class="notification">
            <p><b>Next Payment:</b> 30 days Remaining.</p>
        </div>
    </div>

    <div class="section">
        <h2>Payment History</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Ticket Number</th>
                    <th>Start Point</th>
                    <th>End Point</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment): 
                    // Calculate the status based on the booking date
                    $bookingDate = new DateTime($payment['month']);
                    $currentDate = new DateTime();
                    $interval = $currentDate->diff($bookingDate);
                    $status = ($interval->days <= 30) ? 'Active' : 'Deactivated'; 
                ?>
                <tr>
                    <td><?= htmlspecialchars($payment['month']) ?></td>
                    <td><?= htmlspecialchars($payment['ticket_number']) ?></td>
                    <td><?= htmlspecialchars($payment['start_point']) ?></td>
                    <td><?= htmlspecialchars($payment['end_point']) ?></td>
                    <td><?= $status ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Booking System</h2>
        <a href="#" class="booking-button">Payment for Next Month</a>
        <a href="QR-Code.html" class="booking-button" style="background-color: #dc3545;">Scan the QR Code</a>
    </div>
</div>
                </div>
<script src="Profile.js"></script>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('profile-picture');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
<footer>
        <p>&copy; 2024 Cinec Shuttle Service. All rights reserved.</p>
        <div class="footer-links">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
            <a href="#">Help</a>
        </div>
    </footer>
</body>
</html>

<?php
$stmt->close();
$payment_stmt->close();
$conn->close();
?>
