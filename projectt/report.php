<?php
// Define the file where reports will be stored
$reportFile = 'reports.txt';

// Handle report submission (for users)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userReport'])) {
    $userReport = trim($_POST['userReport']);

    // If the report is not empty, save it to the reports file
    if (!empty($userReport)) {
        $timestamp = date("Y-m-d H:i:s");
        $reportData = "Report submitted at $timestamp\n$userReport\n\n";
        file_put_contents($reportFile, $reportData, FILE_APPEND);
        $message = "Report submitted successfully!";
    } else {
        $message = "Please enter a report before submitting.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - Submit Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .container {
            width: 100%;
            padding: 20px;
        }
        textarea {
            width: 100%;
            height: 150px;
            padding: 10px;
            margin-top: 10px;
        }
        button {
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .title {
            font-weight: bold;
        }
        .message {
            color: green;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h1>User - Submit Report</h1>

<div class="container">
    <h2 class="title">Submit Your Report</h2>

    <!-- User Report Form -->
    <form action="report.php" method="POST">
        <label for="userReport">Report:</label>
        <textarea id="userReport" name="userReport" placeholder="Enter your report here..."></textarea>
        <button type="submit">Submit Report</button>
    </form>

    <!-- Display the message (success or error) after submission -->
    <?php if (isset($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
</div>

</body>
</html>
