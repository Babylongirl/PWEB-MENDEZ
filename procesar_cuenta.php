<?php
// Incluir el archivo de conexión a la base de datos
require_once 'conexion.php';

// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $nombre = $_POST["nombre"];
    $celular = $_POST["celular"];
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    // Encriptar la contraseña
    $contrasena_encriptada = hash('sha256', $contrasena);

    // Preparar y ejecutar la consulta para insertar los datos en la tabla usuario
    $stmt = $conn->prepare("INSERT INTO usuario (NombreUsuario, CelularUsuario, CorreoUsuario, ContrasenaUsuario, IdRol) VALUES (?, ?, ?, ?, 1)");
    $stmt->bind_param("ssss", $nombre, $celular, $correo, $contrasena_encriptada);
    $stmt->execute();

    // Verificar si la inserción fue exitosa
    if ($stmt->affected_rows > 0) {
        echo "¡Usuario creado correctamente!";
    } else {
        echo "Error al crear el usuario: " . $conn->error;
    }

    // Cerrar la declaración preparada
    $stmt->close();
} else {
    // Si no se recibieron los datos del formulario por el método POST, redirigir a la página de inicio
    header("Location: index.html");
    exit();
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
