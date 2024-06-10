<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Conectar a la base de datos MySQL
$servername = "192.168.1.11";
$username = "admin";
$password = "departamento";
$dbname = "log";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener la fecha del formulario
$fecha = $_POST['fecha'];

// Ajustar el formato de fecha para incluir todo el día
$start_date = $fecha . " 00:00:00";
$end_date = $fecha . " 23:59:59";

// Realizar la consulta a la base de datos con filtro de fecha
$sql = "SELECT * FROM repos WHERE timestamp BETWEEN ? AND ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si hay resultados y mostrarlos
if ($result->num_rows > 0) {
    echo "<html><head><link rel='stylesheet' type='text/css' href='css/styles.css'></head><body>";
    echo "<pre>";
    echo "<table border='1'><th>ID</th><th>TEXTO</th><th>FECHA</th>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["texto"] . "</td><td>" . $row["timestamp"] . "</td></tr>";
    }
    echo "</table>";
    echo "</pre>";
} else {
    echo "0 resultados";
}
echo "</body></html>";
// Cerrar la conexión
$stmt->close();
$conn->close();

?>
