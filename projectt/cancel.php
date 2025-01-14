<?php
// DB connection settings
$host = 'localhost';
$db = 'project'; // Change this to your database name
$user = 'root'; // Change this to your DB username
$password = ''; // Change this to your DB password

// Establish connection
$conn = new mysqli($host, $user, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define a variable to hold success/error messages
$message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $username = $_POST['username'];
    $bus_id = $_POST['bus_id'];
    $route = $_POST['route'];
    $seat = $_POST['seat'];

    // Insert the user data into the tickets table
    $sql = "INSERT INTO cancel (username, bus_id, route, seat, status) 
            VALUES ('$username', '$bus_id', '$route', '$seat', 'cancel')";

    if ($conn->query($sql) === TRUE) {
        $message = "Ticket has been cancel successfully!";
    } else {
        $message = "Error booking the ticket: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Ticket Booking</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #8E2DE2, #4A00E0);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            color: #4A00E0;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: #333;
            margin-top: 10px;
        }

        .message {
            font-size: 18px;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .success {
            background-color: #28a745;
            color: white;
        }

        .error {
            background-color: #dc3545;
            color: white;
        }

        label {
            font-size: 16px;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"], input[type="number"], input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus, input[type="number"]:focus {
            border-color: #4A00E0;
            outline: none;
        }

        input[type="submit"] {
            width: 100%;
            padding: 15px;
            background-color: #4A00E0;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #8E2DE2;
        }

        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>cancelYour Bus Ticket</h1>
        <p class="message <?php echo isset($message) && strpos($message, 'success') !== false ? 'success' : 'error'; ?>">
            <?php echo $message; ?>
        </p>

        <form action="cancel.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="bus_id">Bus ID:</label>
                <input type="text" id="bus_id" name="bus_id" required>
            </div>

            <div class="form-group">
                <label for="route">Route:</label>
                <input type="text" id="route" name="route" required>
            </div>

            <div class="form-group">
                <label for="seat">Seat Number:</label>
                <input type="number" id="seat" name="seat" required min="1" max="100">
            </div>

            <input type="submit" value="cancel ticket">
        </form>
    </div>
</body>
</html>
