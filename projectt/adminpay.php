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

// Fetch the payment details (all records)
$sql = "SELECT * FROM payments ORDER BY payment_id DESC"; // Fetch all records
$result = $conn->query($sql);

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 70%;
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
        .form-field {
            margin-bottom: 10px;
        }
        .value {
            font-weight: bold;
        }
        .payment-row {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Payment Details</h1>
    
    <?php if ($result->num_rows > 0): ?>
        <?php while ($paymentData = $result->fetch_assoc()): ?>
            <div class="payment-row">
                <div class="form-field">
                    <label for="bus_id">Bus ID:</label>
                    <div class="value"><?php echo htmlspecialchars($paymentData['bus_id']); ?></div>
                </div>
                
                <div class="form-field">
                    <label for="payment_amount">Payment Amount:</label>
                    <div class="value"><?php echo htmlspecialchars($paymentData['payment_amount']); ?></div>
                </div>
                
                <div class="form-field">
                    <label for="payment_site">Payment Site:</label>
                    <div class="value"><?php echo htmlspecialchars($paymentData['payment_site']); ?></div>
                </div>
                
                <div class="form-field">
                    <label for="payment_id">Payment ID:</label>
                    <div class="value"><?php echo htmlspecialchars($paymentData['payment_id']); ?></div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="message">No payment records found.</div>
    <?php endif; ?>
</div>

</body>
</html>
