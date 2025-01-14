<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root"; // Adjust username if needed
$password = ""; // Adjust password if needed
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bus_id = $_POST['bus_id'];
    $payment_amount = $_POST['payment_amount'];
    $payment_site = $_POST['payment_site'];
    $payment_id = $_POST['payment_id'];

    // Prepare the SQL query
    $stmt = $conn->prepare("INSERT INTO payments (bus_id, payment_amount, payment_site, payment_id) VALUES (?, ?, ?, ?)");

    // Check if the prepare statement was successful
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    // Bind the parameters
    $stmt->bind_param("idss", $bus_id, $payment_amount, $payment_site, $payment_id);

    // Execute the query
    if ($stmt->execute()) {
        $message = "Payment successfully recorded!";
    } else {
        $message = "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 40%;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .message {
            color: green;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Payment Form</h1>
    
    <?php if (isset($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="bus_id">Bus ID:</label>
        <input type="number" id="bus_id" name="bus_id" required>

        <label for="payment_amount">Payment Amount:</label>
        <input type="number" step="0.01" id="payment_amount" name="payment_amount" required>

        <label for="payment_site">Payment Site:</label>
        <select id="payment_site" name="payment_site" required>
            <option value="esewa">eSewa</option>
            <option value="khalti">Khalti</option>
            <option value="credit_card">Credit Card</option>
        </select>

        <label for="payment_id">Payment ID:</label>
        <input type="text" id="payment_id" name="payment_id" required>

        <input type="submit" value="Submit Payment" class="btn">
    </form>
</div>

</body>
</html>
