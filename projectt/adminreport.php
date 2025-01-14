<?php
// Define the file where reports are stored
$reportFile = 'reports.txt';

// Read the reports from the file (if any)
if (file_exists($reportFile)) {
    $reports = file_get_contents($reportFile);
} else {
    $reports = "No reports submitted yet.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Submitted Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .container {
            width: 100%;
            padding: 20px;
        }
        .title {
            font-weight: bold;
        }
        .report {
            margin-top: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
            white-space: pre-wrap;  /* Keeps the line breaks intact */
        }
    </style>
</head>
<body>

<h1>Admin - View Submitted Reports</h1>

<div class="container">
    <h2 class="title">All Submitted Reports</h2>
    
    <!-- Display Reports -->
    <div id="allReports">
        <?php echo nl2br($reports); ?>
    </div>
</div>

</body>
</html>
