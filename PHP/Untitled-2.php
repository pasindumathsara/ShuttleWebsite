<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile Details</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .btn {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            color: white;
            background-color: #007bff;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>STUDENT DETAILS</h1> 
        <table class="table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone Number</th>
                    <th>E-Mail</th>
                    <th>Shuttle ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection details
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

                $sql = "SELECT * FROM students";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }

                while ($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>{$row['StudentID']}</td>
                        <td>{$row['FirstName']}</td>
                        <td>{$row['LastName']}</td>
                        <td>{$row['PhoneNumber']}</td>
                        <td>{$row['EmailAddress']}</td>
                        <td>{$row['RouteID']}</td>
                        <td>
                            <a class='btn' href='/edit.php?id={$row['StudentID']}'>Edit</a>
                            <a class='btn' href='/delete.php?id={$row['StudentID']}'>Delete</a>
                        </td>
                    </tr>";
                }

                $connection->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
