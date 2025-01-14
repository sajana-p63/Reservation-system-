<?php
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
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Verify password
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header("Location: userdash.html"); // Redirect to a dashboard page
            exit();
        } else {
            $login_error = "Incorrect password!";
        }
    } else {
        $login_error = "User not found!";
    }
}

// Handle Signup
if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    // Check if username or email already exists
    $sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $signup_error = "Username or Email already exists!";
    } else {
        // Encrypt password and insert new user
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, full_name, email, phone_number) 
                VALUES ('$username', '$hashed_password', '$full_name', '$email', '$phone_number')";
        
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
    <title>User Login & Signup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin: 10px 0;
            color: #555;
        }

        input[type="text"], input[type="password"], input[type="email"], input[type="tel"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
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
            margin-top: 20px;
        }

        .toggle-link a {
            color: #4CAF50;
            text-decoration: none;
        }

        .toggle-link a:hover {
            text-decoration: underline;
        }

        .form-container {
            display: block;
        }

        .form-container .signup-form {
            display: none;
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

        <div class="form-container">
            <!-- Login Form -->
            <div id="login-form" class="login-form">
                <h2>User Login</h2>
                <form action="user.php" method="POST">
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

            <!-- Signup Form -->
            <div id="signup-form" class="signup-form">
                <h2>User Sign Up</h2>
                <form action="user.php" method="POST">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>

                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>

                    <label for="phone_number">Phone Number</label>
                    <input type="tel" id="phone_number" name="phone_number" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>

                    <input type="submit" name="signup" value="Sign Up">
                </form>
                <div class="toggle-link">
                    <p>Already have an account? <a href="#" onclick="toggleForms()">Login</a></p>
                </div>
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

        // Initially show the login form and hide the signup form
        document.getElementById("login-form").style.display = "block";
        document.getElementById("signup-form").style.display = "none";
    </script>

</body>
</html>
