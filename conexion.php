<?php
// Datos de conexión a la base de datos
$servername = "localhost"; // Puede que necesites cambiarlo si tu servidor de MySQL está en un host diferente
$username = "root"; // Usuario de MySQL (en este caso, root)
$password = ""; // Deja el campo de contraseña vacío si estás utilizando el usuario root sin contraseña
$database = "revision3"; // Nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Establecer el juego de caracteres a UTF-8
$conn->set_charset("utf8mb4");

?>
