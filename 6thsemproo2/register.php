<?php
$conn = new mysqli("localhost", "root", "", "6thsemproo2");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $role = $_POST["role"];

    if ($username == "" || $password == "") {
        $message = "Please fill all fields";
    } else {

        $sql = "INSERT INTO users (username, password, role)
                VALUES ('$username', '$password', '$role')";

        if ($conn->query($sql) === TRUE) {

            echo "<script>
                alert('Registered Successfully!');
                window.location.href = 'login.php';
            </script>";
            exit();

        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register</title>

  <style>
    body{
      height:100vh;
      display:flex;
      justify-content:center;
      align-items:center;
      background:linear-gradient(135deg,#1d2671,#c33764);
      font-family:Poppins, sans-serif;
      color:white;
    }

    .box{
      width:350px;
      padding:30px;
      background:rgba(255,255,255,0.1);
      border-radius:15px;
      text-align:center;
      box-shadow:0 10px 25px rgba(0,0,0,0.3);
    }

    input,select{
      width:100%;
      padding:10px;
      margin:10px 0;
      border:none;
      border-radius:8px;
      outline:none;
    }

    button{
      width:100%;
      padding:10px;
      background:linear-gradient(45deg,#ff512f,#dd2476);
      border:none;
      color:white;
      cursor:pointer;
      border-radius:8px;
      font-size:16px;
    }

    .login-btn{
      margin-top:10px;
      display:block;
      text-decoration:none;
      padding:10px;
      border-radius:8px;
      background:linear-gradient(45deg,#3333ff,#00c6ff);
      color:white;
      font-size:15px;
    }

    .msg{
      color:#ffd369;
      margin-bottom:10px;
    }
  </style>
</head>

<body>

<div class="box">
  <h2>Register</h2>

  <?php if($message != "") echo "<div class='msg'>$message</div>"; ?>

  <form method="POST">

    <input type="text" name="username" placeholder="Username" required>

    <input type="password" name="password" placeholder="Password" required>

    <select name="role">
      <option value="customer">Customer</option>
      <option value="farmer">Farmer</option>
      <option value="supplier">Supplier</option>
      <option value="admin">Admin</option>
    </select>

    <button type="submit">Register</button>

  </form>

  <!-- ✅ LOGIN BUTTON -->
  <a class="login-btn" href="login.php">Go to Login</a>

</div>

</body>
</html>