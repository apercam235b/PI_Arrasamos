<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Añadimos depuración para verificar la ejecución del script PHP
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['arg'])) {
        $arg = escapeshellarg($_POST['arg']); // Escapamos el argumento para seguridad
        echo "Ejecutando script de Python con argumento: $arg<br>";

        // Ejecutar el script de Python y capturar la salida
        $output = shell_exec("python3 /var/www/html/script.py $arg 2>&1");
        echo "<pre>";
        echo $output;
        echo "</pre>";

        // Redirigir a success.php después de ejecutar el script
        header("Location: success.php");
        exit();
    } else {
        echo "No se recibió ningún argumento.";
    }
} else {
    echo "Método de solicitud no válido.";
}
?>
