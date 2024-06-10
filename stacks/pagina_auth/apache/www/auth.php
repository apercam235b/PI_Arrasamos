<?php
session_start();

$servername = "db";
$username = "user";
$password = "password";
$dbname = "mydb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$user = $_POST['username'];
$pass = $_POST['password'];

$sql = "SELECT * FROM users WHERE username='$user' AND password='$pass'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $_SESSION['username'] = $user;
  header("Location: success.php");
} else {
  echo "<!DOCTYPE html>
<html>
<head>
    <title>Invalid Credentials</title>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"styles.css\">
</head>
<body>
    <div class=\"container\">
        <h1>Invalid credentials</h1>
    </div>
</body>
</html>";
}

$conn->close();
?>
