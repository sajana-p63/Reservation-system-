<?php
$conn = new mysqli("localhost", "root", "", "6thsemproo2");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/* ================= LOGIN ================= */
if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users 
            WHERE username='$username' AND password='$password'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        echo "<script>
            alert('Login Successful');
            window.location.href='".($row['role']=="customer" ? "consumer.html" : "admin.php")."';
        </script>";

    } else {
        echo "<script>alert('Invalid login');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login - AgroMarket</title>

<style>
body{
  margin:0;
  font-family:poppins;
  background:linear-gradient(135deg,#1d2671,#c33764);
  display:flex;
  justify-content:center;
  align-items:center;
  height:100vh;
  color:white;
}

.box{
  width:320px;
  padding:30px;
  background:rgba(255,255,255,0.1);
  border-radius:15px;
  text-align:center;
  box-shadow:0 10px 25px rgba(0,0,0,0.3);
}

input{
  width:100%;
  padding:10px;
  margin:10px 0;
  border:none;
  border-radius:8px;
}

button{
  width:100%;
  padding:10px;
  border:none;
  border-radius:8px;
  background:linear-gradient(45deg,#ff512f,#dd2476);
  color:white;
  cursor:pointer;
}

a{
  color:#ffd369;
  text-decoration:none;
}
</style>

</head>

<body>

<div class="box">

<h2>Login</h2>

<form method="POST">

<input name="username" placeholder="Username" required>
<input name="password" type="password" placeholder="Password" required>

<button type="submit" name="login">Login</button>

</form>

<p>Don't have account? <a href="register.php">Register</a></p>

</div>

</body>
</html>