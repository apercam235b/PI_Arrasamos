<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Successful</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<div class="center-content">
            <img src="./images/arrasamos.png" alt="Arrasamos-removebg-preview" border="0">
    </div>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <form method="post" action="script.php">
        <label for="arg">Iniciar clase, indique nombre de la clase:</label>
        <input type="text" id="arg" name="arg" required>
        <input type="submit" value="Run Python Script">
    </form>
    <form method="post" action="log.php">
        <label for="fecha">LOG Fecha:</label>
        <input type="date" id="fecha" name="fecha">
        <input type="submit" value="Filtrar">
    </form>
    <form action="http://192.168.1.11:5001">
        <input type="submit" value="Dockge">
    </form>
    <form action="http://192.168.1.11:8080">
        <input type="submit" value="FileBrowser">
    </form>
    <form method="post" action="logout.php">
        <input type="submit" value="Logout">
    </form>
</body>
</html>
