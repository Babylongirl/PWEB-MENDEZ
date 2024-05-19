<?php
include 'conexion.php'; // Incluye tu archivo de conexión

// Verifica si se ha pasado el ID del empleado en la URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Convierte el ID a un número entero para mayor seguridad

    // Prepara y ejecuta la consulta para eliminar el empleado
    $sql = "DELETE FROM usuario WHERE IdUsuario = ? AND IdRol = 2";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Si la eliminación fue exitosa, redirige a la página de gestión de empleados
        header("Location: empleadoscrud.php");
        exit;
    } else {
        echo "Error al eliminar el empleado: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ID de empleado no especificado.";
}

$conn->close();
?>
