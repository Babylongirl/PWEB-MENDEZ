<?php
include 'conexion.php'; // Incluye tu archivo de conexión

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $celular = $_POST['celular'];
    $contrasena = $_POST['contrasena'];

    if (!empty($contrasena)) {
        $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);
        $sql = "UPDATE usuario SET NombreUsuario = ?, CorreoUsuario = ?, CelularUsuario = ?, ContrasenaUsuario = ? WHERE IdUsuario = ? AND IdRol = 2";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $correo, $celular, $contrasenaHash, $id);
    } else {
        $sql = "UPDATE usuario SET NombreUsuario = ?, CorreoUsuario = ?, CelularUsuario = ? WHERE IdUsuario = ? AND IdRol = 2";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $correo, $celular, $id);
    }

    if ($stmt->execute()) {
        echo "Empleado actualizado correctamente.";
    } else {
        echo "Error al actualizar el empleado: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ID de empleado no especificado.";
}

$conn->close();
?>
