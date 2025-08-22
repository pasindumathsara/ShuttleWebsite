<?php
session_start();
include 'config.php';

// Handle Add Shuttle
if (isset($_POST['add_shuttle'])) {
    $bus_number = $_POST['bus_number'];
    $driver_name = $_POST['driver_name'];
    $id_no = $_POST['id_no'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $price = $_POST['price'];

    // Insert shuttle into the database
    $sql = "INSERT INTO shuttle_details (Bus_Number, Driver_name, Id_no, Departure_time, Arrival_time, Price) 
            VALUES ('$bus_number', '$driver_name', '$id_no', '$departure_time', '$arrival_time', '$price')";
    $conn->query($sql);
}

// Handle Edit Shuttle
if (isset($_POST['edit_shuttle'])) {
    $bus_number = $_POST['bus_number'];
    $driver_name = $_POST['driver_name'];
    $id_no = $_POST['id_no'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $price = $_POST['price'];

    // Update shuttle in the database
    $sql = "UPDATE shuttle_details SET Driver_name='$driver_name', Id_no='$id_no', Departure_time='$departure_time', Arrival_time='$arrival_time', Price='$price' WHERE Bus_Number='$bus_number'";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating record: " . $conn->error . "');</script>";
    }
}

// Handle Delete Shuttle by Bus Number
if (isset($_POST['delete_shuttle'])) {
    $bus_number = $_POST['bus_number'];

    // Delete shuttle from the database
    $sql = "DELETE FROM shuttle_details WHERE Bus_Number='$bus_number'";
    $conn->query($sql);
}

// Fetch all shuttles to display
$sql = "SELECT * FROM shuttle_details";
$shuttle_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Shuttle Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #f0f4f8, #e2eafc);
            color: #333;
            margin: 0;
            padding: 20px;
            transition: background 0.5s;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 2.5rem;
        }
        form {
            margin-bottom: 20px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            width: 500px;
        }
        form:hover {
            transform: scale(1.02);
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            color: #34495e;
        }
        input[type="text"], input[type="number"], input[type="time"] {
            width: calc(100% - 12px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
            transition: border 0.3s;
        }
        input[type="text"]:focus, input[type="number"]:focus, input[type="time"]:focus {
            border-color: #3498db;
            outline: none;
        }
        button {
            padding: 10px 15px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 1rem;
            margin-top: 10px;
        }
        button:hover {
            background-color: #2980b9;
        }
        button.delete {
            background-color: #e74c3c;
        }
        button.delete:hover {
            background-color: #c0392b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #bdc3c7;
        }
        th {
            background-color: #3498db;
            color: white;
            font-weight: 700;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        #editModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            z-index: 1000;
            transition: transform 0.3s;
        }
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 999;
        }
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }
        }
        footer {
            background-color: #1b3e54;
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
            bottom: 0;
            width: 100%;
            top: 105px;
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
            background-color: #1b3e54;
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
            background-color: #1b3e54;
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

        .image-slider {
    position: relative;
    max-width: 600px; /* Adjust according to your layout */
    margin: auto;
    overflow: hidden;
    border-radius: 10px; /* Optional: Adds rounded corners */
}

.slides {
    display: flex;
    transition: transform 0.5s ease-in-out;
}

.slide {
    min-width: 100%;
    box-sizing: border-box;
}

.slide img {
    width: 100%; /* Make image responsive */
    height: auto; /* Maintain aspect ratio */
}

.navigation {
    position: absolute;
    top: 50%;
    width: 100%;
    display: flex;
    justify-content: space-between;
    transform: translateY(-50%);
}

button.prev, button.next {
    background-color: rgba(255, 255, 255, 0.8);
    border: none;
    cursor: pointer;
    padding: 10px;
    border-radius: 5px;
}

    </style>
</head>
<body>

<div class="navbar">
    <div class="top-bar">
        <img src="../Images/iconss.jpg" alt="" width="120px" height="90px" style="position:relative; top: 2px;left: 50px; border-radius:5px">
        
        <div class="search-container" style="position: relative;left: 120px;">
            <input type="text" id="searchBar" placeholder="Search events..." onclick="toggleEventList()" oninput="filterEvents()">
            <div class="search-icon"></div>
            <img src="../Images/icons8-search-50.png" alt="" style="position: relative; width: 28px; height: 28px; left: -50px;">
        </div>
    </div>
    <div class="bottom-bar">
        <a href="home.html" style="position: relative;left: 290px;">Home</a>
        <a href="New_Catergory.html" style="position: relative;left: 120px;">Categories</a>
        <a href="event.html" style="position: relative;left: -50px;">Events</a>
        <a href="contactus2.html" style="position: relative;left: -220px;">Contact Us</a>
        <button class="profile-btn" onclick="window.location.href='logout.php'" style="background-color:#1b3e54; position:relative; font-size:16px; color:white">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </div>
</div>

    <h1 style="position : relative;  top:50px">Admin Panel - Manage Shuttle Details</h1>   
    <div class="image-slider" style="position : relative; left:250px; top:150px  ">
    <div class="slides">
        <div class="slide active">
            <img src="../Images/cinec.jpg" alt="Image 1">
        </div>
        <div class="slide">
            <img src="../Images/sliderim.jpg" alt="Image 2">
        </div>
        <div class="slide">
            <img src="path/to/your/image3.jpg" alt="Image 3">
        </div>
    </div>
    <div class="navigation">
        <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
        <button class="next" onclick="changeSlide(1)">&#10095;</button>
    </div>
</div>
    <!-- Add Shuttle Form -->
    <h2>Add a Shuttle</h2>
    <form method="POST" action="" style="position : relative;  top:-270px">
        <label for="bus_number">Bus Number:</label>
        <input type="text" name="bus_number" id="bus_number" required>

        <label for="driver_name">Driver Name:</label>
        <input type="text" name="driver_name" id="driver_name" required>

        <label for="id_no">Driver ID No:</label>
        <input type="text" name="id_no" id="id_no" required>

        <label for="departure_time">Departure Time:</label>
        <input type="time" name="departure_time" id="departure_time" required>

        <label for="arrival_time">Arrival Time:</label>
        <input type="time" name="arrival_time" id="arrival_time" required>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" required>

        <button type="submit" name="add_shuttle">Add Shuttle</button>
    </form>

    <!-- Display Existing Shuttle Details -->
    <h2 style="position : relative;  top:-200px; left:20px">Shuttle Details</h2>
    <table style="position : relative;  top:-200px">
        <thead>
            <tr>
                <th>Bus Number</th>
                <th>Driver Name</th>
                <th>Driver ID No</th>
                <th>Departure Time</th>
                <th>Arrival Time</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Output shuttle rows from the database -->
            <?php while ($shuttle = $shuttle_result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($shuttle['Bus_Number']) ?></td>
                <td><?= htmlspecialchars($shuttle['Driver_name']) ?></td>
                <td><?= htmlspecialchars($shuttle['Id_no']) ?></td>
                <td><?= htmlspecialchars($shuttle['Departure_time']) ?></td>
                <td><?= htmlspecialchars($shuttle['Arrival_time']) ?></td>
                <td><?= htmlspecialchars($shuttle['price']) ?></td>
                <td>
                    <!-- Form for editing a shuttle -->
                    <button type="button" onclick="openEditModal('<?= htmlspecialchars($shuttle['Bus_Number']) ?>', '<?= htmlspecialchars($shuttle['Driver_name']) ?>', '<?= htmlspecialchars($shuttle['Id_no']) ?>', '<?= htmlspecialchars($shuttle['Departure_time']) ?>', '<?= htmlspecialchars($shuttle['Arrival_time']) ?>', '<?= htmlspecialchars($shuttle['price']) ?>')">Edit</button>
                    <!-- Form for deleting a shuttle -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="bus_number" value="<?= htmlspecialchars($shuttle['Bus_Number']) ?>">
                        <button type="submit" name="delete_shuttle" class="delete">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Edit Shuttle Modal -->
    <div id="editModal" class="modal-overlay">
        <div class="modal-content">
            <h2>Edit Shuttle</h2>
            <form method="POST" action="">
                <input type="hidden" name="bus_number" id="edit_bus_number">

                <label for="edit_driver_name">Driver Name:</label>
                <input type="text" name="driver_name" id="edit_driver_name" required>

                <label for="edit_id_no">Driver ID No:</label>
                <input type="text" name="id_no" id="edit_id_no" required>

                <label for="edit_departure_time">Departure Time:</label>
                <input type="time" name="departure_time" id="edit_departure_time" required>

                <label for="edit_arrival_time">Arrival Time:</label>
                <input type="time" name="arrival_time" id="edit_arrival_time" required>

                <label for="edit_price">Price:</label>
                <input type="number" name="price" id="edit_price" required>

                <button type="submit" name="edit_shuttle">Update Shuttle</button>
                <button type="button" onclick="closeEditModal()">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        // Open the edit modal with shuttle details
        function openEditModal(busNumber, driverName, idNo, departureTime, arrivalTime, price) {
            document.getElementById('edit_bus_number').value = busNumber;
            document.getElementById('edit_driver_name').value = driverName;
            document.getElementById('edit_id_no').value = idNo;
            document.getElementById('edit_departure_time').value = departureTime;
            document.getElementById('edit_arrival_time').value = arrivalTime;
            document.getElementById('edit_price').value = price;
            document.getElementById('editModal').style.display = 'block';
            document.querySelector('.modal-overlay').style.display = 'block';
        }

        // Close the edit modal
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
            document.querySelector('.modal-overlay').style.display = 'none';

            let currentSlide = 0;

function showSlide(index) {
    const slides = document.querySelectorAll('.slide');
    if (index >= slides.length) {
        currentSlide = 0;
    } else if (index < 0) {
        currentSlide = slides.length - 1;
    } else {
        currentSlide = index;
    }
    
    const offset = -currentSlide * 100;
    document.querySelector('.slides').style.transform = 'translateX(' + offset + '%)';
}

function changeSlide(direction) {
    showSlide(currentSlide + direction);
}

// Automatically change slides every 5 seconds (optional)
setInterval(() => {
    changeSlide(1);
}, 5000);
        }
    </script>
    
<footer>
    <p>&copy; 2024 Your Company Name. All rights reserved.</p>
    <div class="footer-links">
        <a href="privacy.html">Privacy Policy</a>
        <a href="terms.html">Terms of Service</a>
        <a href="support.html">Support</a>
    </div>
</footer>

</body>
</html>
