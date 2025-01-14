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

// Handle Create operation (Add new booking)
if (isset($_POST['submit'])) {
    $user_name = $_POST['user_name'];
    $Bus_number = $_POST['Bus_number'];
    $destination = $_POST['destination'];
    $seats = $_POST['seats'];

    // Insert data into the database
    $sql = "INSERT INTO bookings (user_name, Bus_number, destination, seats) VALUES ('$user_name', '$Bus_number', '$destination', '$seats')";
    if ($conn->query($sql) === TRUE) {
        header("Location:payment.php? status=sucess");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Booking Dashboard - Bus Reservation System</title>
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

        form {
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #4e73df;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2e59d9;
        }

        .cancel-button {
            background-color: #f44336;
            color: white;
        }

        .cancel-button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage your tickets</h1>

        <!-- Add Booking Form -->
        <form action="ubooking.php" method="POST">
            <h3>Add New Booking</h3>
            <label for="user_name">User Name</label>
            <input type="text" name="user_name" id="user_name" required>

            <label for="Bus_number">Bus number</label>
            <input type="number" name="Bus_number" id="Bus_number" required>

            <label for="destination">destination</label>
            <input type="text" name="destination" id="destination" required>

            <label for="seats">Seats</label>
            <input type="text" name="seats" id="seats" required>

            <button type="submit" name="submit"onclick="window.location.href='payment.php';" >Submit Booking</button>
            <!-- Cancel Button -->
            <button type="button" class="cancel-button" onclick="window.location.href='cancel.php';">Cancel</button>
        
        
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
