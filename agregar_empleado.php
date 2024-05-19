<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $celular = $_POST['celular'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';
    $idRol = 2; // Rol de administrador

    if (empty($nombre) || empty($correo) || empty($celular) || empty($contrasena)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT); // Encripta la contraseña

    $sql = "INSERT INTO usuario (NombreUsuario, CorreoUsuario, CelularUsuario, ContrasenaUsuario, IdRol) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("ssssi", $nombre, $correo, $celular, $contrasenaHash, $idRol);

    if ($stmt->execute()) {
        header("Location: empleados.php");
        exit;
    } else {
        echo "Error al ejecutar la consulta: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
