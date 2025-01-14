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
    $bus_id = $_POST['Bus_number'];
    $route = $_POST['destination'];
    $seats = $_POST['seats'];

    // Insert data into the database
    $sql = "INSERT INTO bookings (user_name, Bus_number, destination, seats) VALUES ('$user_name', '$Bus_number', '$destination', '$seats')";
    if ($conn->query($sql) === TRUE) {
        echo "Booking successfully added!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle Update operation (Edit booking)
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $user_name = $_POST['user_name'];
    $Bus_number= $_POST['Bus_number'];
    $destination = $_POST['destination'];
    $seats = $_POST['seats'];

    // Update booking details
    $sql = "UPDATE bookings SET user_name='$user_name', Bus_number='$Bus_number', destination='$destination', seats='$seats' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Booking successfully updated!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle Delete operation (Delete booking)
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Delete booking
    $sql = "DELETE FROM bookings WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Booking successfully deleted!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Retrieve all bookings
$result = $conn->query("SELECT * FROM bookings");

// Handle Edit operation (populate fields for update)
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM bookings WHERE id='$id'");
    $booking = $result->fetch_assoc();
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
            margin-right: 5px;
        }

        a:hover {
            background-color: #f1f1f1;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Booking Dashboard</h1>

        <!-- Add Booking Form -->
        <form action="booking.php" method="POST">
            <h3>Add New Booking</h3>
            <label for="user_name">User Name</label>
            <input type="text" name="user_name" id="user_name" required>

            <label for="Bus_number">Bus number</label>
            <input type="number" name="Bus_number" id="Bus_number" required>

            <label for="destination">destination</label>
            <input type="text" name="destination" id="destination" required>

            <label for="seats">Seats</label>
            <input type="number" name="seats" id="seats" required>

            <button type="submit" name="submit">Add Booking</button>
        </form>

        <h3>Existing Bookings</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User Name</th>
                    <th>Bus number</th>
                    <th>destination</th>
                    <th>Seats</th>
                    <th>Booking Date</th>
                    <th>Actions</th>
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
                        <td>
                            <!-- Edit and Delete Actions -->
                            <a href="booking.php?edit=<?php echo $row['id']; ?>">Edit</a>
                            <a href="booking.php?delete=<?php echo $row['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php
        // Handle Edit operation (populate fields for update)
        if (isset($_GET['edit'])) {
        ?>
            <!-- Edit Booking Form -->
            <form action="booking.php" method="POST">
                <h3>Edit Booking</h3>
                <input type="hidden" name="id" value="<?php echo $booking['id']; ?>">

                <label for="user_name">User Name</label>
                <input type="text" name="user_name" id="user_name" value="<?php echo $booking['user_name']; ?>" required>

                <label for="Bus_number">Bus Number</label>
                <input type="number" name="Bus_number" id="Bus_number" value="<?php echo $booking['Bus_number']; ?>" required>

                <label for="destination">Route</label>
                <input type="text" name="destination" id="destination" value="<?php echo $booking['destination']; ?>" required>

                <label for="seats">Seats</label>
                <input type="number" name="seats" id="seats" value="<?php echo $booking['seats']; ?>" required>

                <button type="submit" name="update">Update Booking</button>
            </form>
        <?php } ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
