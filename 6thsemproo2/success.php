<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "6thsemproo2");

// Check if eSewa sent the 'data' parameter
if (isset($_GET['data'])) {
    // 1. Decode the Base64 data from eSewa
    $encoded_data = $_GET['data'];
    $decoded_json = base64_decode($encoded_data);
    $response = json_decode($decoded_json, true);

    // 2. Extract values safely
    $status = $response['status'] ?? '';
    $total_amount = $response['total_amount'] ?? 0;
    $transaction_uuid = $response['transaction_uuid'] ?? '';
    $transaction_code = $response['transaction_code'] ?? '';

    // 4. Update your database if payment is complete
    if ($status === "COMPLETE") {
        $stmt = $conn->prepare("UPDATE payments SET amount = ?, product_code = 'SUCCESS' WHERE transaction_id = ?");
        $stmt->bind_param("ds", $total_amount, $transaction_uuid);
        $stmt->execute();
        $stmt->close();
    }
} else {
    echo "<h1>Invalid Access</h1>";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f6f8;
        }
        .container {
            margin-top: 100px;
            background: #fff;
            padding: 30px;
            display: inline-block;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .btn {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>

    <!-- Auto Redirect after 5 seconds -->
    <script>
        setTimeout(function() {
            window.location.href = "index.php";
        }, 5000);
    </script>
</head>
<body>

<div class="container">
    <h1>Payment Successful ✅</h1>
    <p><strong>Amount:</strong> Rs. <?php echo htmlspecialchars($total_amount); ?></p>
    <p><strong>Transaction ID:</strong> <?php echo htmlspecialchars($transaction_uuid); ?></p>
    <p><strong>eSewa Ref Code:</strong> <?php echo htmlspecialchars($transaction_code); ?></p>

    <p>You will be redirected to home in 5 seconds...</p>

    <a href="index.php">
        <button class="btn">Go to Home Now</button>
    </a>
</div>

</body>
</html>