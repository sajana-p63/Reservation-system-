<?php
// 1. Database configuration matching your screenshot
$host = "localhost";
$user = "root";
$pass = "";
$db   = "6thsemproo2"; // Updated to your actual DB name

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    die("Connection failed: " . $conn->connect_error);
}

// 2. Handle the POST request from consumer.html
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Get the data sent by the JavaScript fetch()
    $txn_uuid = $_POST['transaction_uuid'] ?? 'N/A';
    $amt = $_POST['amount'] ?? 0;
    $p_code = "EPAYTEST"; // Default for eSewa test environment

    // 3. Prepare and bind to the 'payments' table
    // Columns: amount (decimal/double), transaction_id (string), product_code (string)
    $stmt = $conn->prepare("INSERT INTO payments (amount, transaction_id, product_code) VALUES (?, ?, ?)");
    
    // "dss" means: d = double/decimal, s = string, s = string
    $stmt->bind_param("dss", $amt, $txn_uuid, $p_code);
    
    if ($stmt->execute()) {
        echo "Success: Payment record created in database.";
    } else {
        http_response_code(500);
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close();
?>