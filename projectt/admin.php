<?php
// Start the session
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "project"; // Your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle Login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to fetch user from the database
    $sql = "SELECT * FROM admins WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Verify password
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header("Location: dash.php"); // Redirect to the dashboard
            exit();
        } else {
            $login_error = "Incorrect password!";
        }
    } else {
        $login_error = "Admin not found!";
    }
}

// Handle Signup
if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username already exists
    $sql = "SELECT * FROM admins WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $signup_error = "Username already exists!";
    } else {
        // Encrypt password and insert new admin
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO admins (username, password) VALUES ('$username', '$hashed_password')";
        
        if (mysqli_query($conn, $sql)) {
            $signup_success = "Account created successfully! You can now login.";
        } else {
            $signup_error = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login & Signup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin: 10px 0;
            color: #555;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        .success {
            color: green;
            text-align: center;
            margin-bottom: 15px;
        }

        .toggle-link {
            text-align: center;
            margin-top: 15px;
        }

        .toggle-link a {
            color: #4CAF50;
            text-decoration: none;
        }

        .toggle-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <?php if (isset($login_error)): ?>
            <div class="error"><?= $login_error ?></div>
        <?php endif; ?>
        <?php if (isset($signup_error)): ?>
            <div class="error"><?= $signup_error ?></div>
        <?php endif; ?>
        <?php if (isset($signup_success)): ?>
            <div class="success"><?= $signup_success ?></div>
        <?php endif; ?>

        <!-- Toggle between Login and Signup forms -->
        <div id="login-form">
            <h2>Admin Login</h2>
            <form action="admin.php" method="POST">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <input type="submit" name="login" value="Login">
            </form>
            <div class="toggle-link">
                <p>Don't have an account? <a href="#" onclick="toggleForms()">Sign Up</a></p>
            </div>
        </div>

        <div id="signup-form" style="display:none;">
            <h2>Admin Sign Up</h2>
            <form action="admin.php" method="POST">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <input type="submit" name="signup" value="Sign Up">
            </form>
            <div class="toggle-link">
                <p>Already have an account? <a href="#" onclick="toggleForms()">Login</a></p>
            </div>
        </div>
    </div>

    <script>
        // Toggle between login and signup forms
        function toggleForms() {
            var loginForm = document.getElementById("login-form");
            var signupForm = document.getElementById("signup-form");
            
            if (loginForm.style.display === "none") {
                loginForm.style.display = "block";
                signupForm.style.display = "none";
            } else {
                loginForm.style.display = "none";
                signupForm.style.display = "block";
            }
        }
    </script>

</body>
</html>
