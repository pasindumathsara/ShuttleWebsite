<?php
$servername = "localhost";
$username = "root";
$password = "";
$database_name = "shuttle_link";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database_name);

// Check connection
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Handle reply submission
if (isset($_POST['reply'])) {
    $contact_id = $_POST['contact_id'];
    $reply = $_POST['reply_message'];

    // Insert reply into the message_replies table
    $sql_reply = "INSERT INTO message_replies (Contact_ID, Reply) VALUES('$contact_id', '$reply')";
    if (mysqli_query($conn, $sql_reply)) {
        // Update the status of the message to 'replied'
        $sql_update_status = "UPDATE contact_page SET Status='replied' WHERE ID='$contact_id'";
        mysqli_query($conn, $sql_update_status);
        echo "<script>alert('Reply sent successfully.');</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Fetch messages
$sql_fetch = "SELECT * FROM contact_page ORDER BY Created_at DESC";
$result = mysqli_query($conn, $sql_fetch);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Contact Messages</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #007BFF;
            color: white;
            text-align: left;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .reply-form {
            margin: 10px 0;
        }
        .reply-form textarea {
            width: 100%;
            height: 60px;
            margin-bottom: 10px;
            padding: 10px;
        }
        .reply-form button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
        }
        .reply-form button:hover {
            background-color: #218838;
        }
        
        footer {
            background-color: #1b3e54;
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
            bottom: 0;
            width: 100%;
            top:105px;
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
            margin-right: 10px; /* Added margin */
        }

        .search-icon {
            background: url('icons8-search-50.png') no-repeat center;
            width: 24px;
            height: 24px;
            cursor: pointer;
            position: absolute;
            right: 10px; /* Positioned right side of search bar */
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

    </style>
</head>
<body>
<div class="navbar">
        <div class="top-bar">
            <img src="../Images/iconss.jpg" alt="" width="120px" height="90px" style="position:relative; top: 2px;left: 00px; border-radius:5px">
            
            <div class="search-container" style="position: relative;left:120px;" >
                <input type="text" id="searchBar" placeholder="Search events..." onclick="toggleEventList()" oninput="filterEvents()">
                <div class="search-icon"></div>
                <img src="../Images/icons8-search-50.png" alt="" style="position: relative; width: 28px; height: 28px; left: -50px;">
            </div>
            <img src="../Images/admin3.jpg" alt="" style="position: relative; width: 40px; height: 40px; left: 330px;">
            <a href="StudentProfile.php" style="position: relative;left: 330px;">My Profile</a>
            
                
        </div>
        <div class="bottom-bar">
            <a href="../homepage.html"style="position: relative;left: 290px;">Home</a>
            <a href="New_Catergory.html"style="position: relative;left: 120px;">Categories</a>
            <a href="event.html"style="position: relative;left: -50px;">Events</a>
            <a href="contactus2.html"style="position: relative;left: -220px;">Contact Us</a>
            <button class="profile-btn" onclick="window.location.href='logout.php'" style="background-color:#1b3e54; position:relative;width:00px; font-size:16px;colour:white">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
           
        </div>
</div>
<h2>User Contact Messages</h2>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Message</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Name']); ?></td>
                    <td><?php echo htmlspecialchars($row['Email_address']); ?></td>
                    <td><?php echo htmlspecialchars($row['Phone_Number']); ?></td>
                    <td><?php echo htmlspecialchars($row['Message']); ?></td>
                    <td><?php echo htmlspecialchars($row['Status']); ?></td>
                    <td>
                        <button onclick="document.getElementById('reply-form-<?php echo $row['ID']; ?>').style.display='block'">Reply</button>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <div id="reply-form-<?php echo $row['ID']; ?>" class="reply-form" style="display:none;">
                            <form method="POST">
                                <input type="hidden" name="contact_id" value="<?php echo $row['ID']; ?>">
                                <textarea name="reply_message" required placeholder="Write your reply..."></textarea>
                                <button type="submit" name="reply">Send Reply</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No messages found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<h3>Chat History</h3>
<?php
// Fetch replies for each contact message
$sql_replies = "SELECT r.*, c.Name FROM message_replies r JOIN contact_page c ON r.Contact_ID = c.ID ORDER BY r.Created_at DESC";
$result_replies = mysqli_query($conn, $sql_replies);

if (mysqli_num_rows($result_replies) > 0): ?>
    <ul>
        <?php while ($reply = mysqli_fetch_assoc($result_replies)): ?>
            <li>
                <strong><?php echo htmlspecialchars($reply['Name']); ?>:</strong> <?php echo htmlspecialchars($reply['Reply']); ?> <em>(<?php echo $reply['Created_at']; ?>)</em>
            </li>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p>No chat history found.</p>
<?php endif; ?>
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
// Close connection
mysqli_close($conn);
?>
