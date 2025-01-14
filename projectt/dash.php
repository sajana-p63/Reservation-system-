<?php
// Database Connection
$host = "localhost"; // Database host
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "project"; // Database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve all bookings
$result = $conn->query("SELECT * FROM bookings");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bus Reservation System</title>
    <link rel="stylesheet" href="dash.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #4e73df;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #4e73df;
            color: white;
        }

        a {
            color: #4e73df;
            text-decoration: none;
            padding: 5px 10px;
        }

        a:hover {
            background-color: #f1f1f1;
            border-radius: 4px;
        }

        .sidebar {
            background-color: #333;
            color: white;
            width: 250px;
            height: 100%;
            position: fixed;
            padding: 20px;
        }

        .sidebar-header h2 {
            font-size: 24px;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            display: block;
            padding: 10px;
            border-radius: 4px;
        }

        .sidebar ul li a:hover {
            background-color: #4e73df;
        }

        .content {
            margin-left: 270px;
            padding: 20px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Admin Dashboard</h2>
        </div>
        <ul>
            <li><a href="booking.php">Bookings</a></li>
            <li><a href="adminpay.php">payment</a></li>
            <li><a href="#">Users</a></li>
            <li><a href="#">Buses</a></li>
            <li><a href="available.php">available buses</a></li>
            <li><a href="adminreport.php">Reports</a></li>
            <li><a href="#">Settings</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="container">
          

        
            <table>
                <thead>
                    <tr>
                        <h1>Booking lists</h1>
                        <th>ID</th>
                        <th>User Name</th>
                        <th>Bus ID</th>
                        <th>Route</th>
                        <th>Seats</th>
                        <th>Booking Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['user_name']; ?></td>
                            <td><?php echo $row['Bus_number']; ?></td>
                            <td><?php echo $row['destination']; ?></td>
                            <td><?php echo $row['seats']; ?></td>
                            <td><?php echo $row['booking_date']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>

<?php
$conn->close();
?>
