<?php
include 'conexion.php';

// Verificar si se recibieron los datos del formulario por el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $usuario_id = $_SESSION['usuario_id'] ?? null;
    $contrasena_actual = $_POST["contrasena_actual"];
    $nueva_contrasena = $_POST["nueva_contrasena"];
    $confirmar_contrasena = $_POST["confirmar_contrasena"];

    if (empty($usuario_id) || empty($contrasena_actual) || empty($nueva_contrasena) || empty($confirmar_contrasena)) {
        echo "Todos los campos son obligatorios.";
    } else {
        // Obtener la contraseña actual del usuario
        $sql = "SELECT ContrasenaUsuario FROM usuario WHERE IdUsuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $usuario = $result->fetch_assoc();
            $contrasena_actual_bd = $usuario['ContrasenaUsuario'];

            // Verificar si la contraseña actual proporcionada coincide con la almacenada en la base de datos
            if (password_verify($contrasena_actual, $contrasena_actual_bd)) {
                // Verificar si la nueva contraseña y la confirmación coinciden
                if ($nueva_contrasena === $confirmar_contrasena) {
                    // Encriptar la nueva contraseña
                    $nueva_contrasena_encriptada = password_hash($nueva_contrasena, PASSWORD_BCRYPT);

                    // Actualizar la contraseña del usuario en la base de datos
                    $sql_update = "UPDATE usuario SET ContrasenaUsuario = ? WHERE IdUsuario = ?";
                    $stmt_update = $conn->prepare($sql_update);
                    $stmt_update->bind_param("si", $nueva_contrasena_encriptada, $usuario_id);
                    $stmt_update->execute();

                    if ($stmt_update->affected_rows > 0) {
                        // Contraseña actualizada con éxito
                        $_SESSION['contrasena_cambiada'] = true;
                        header("Location: menucliente.php");
                        exit();
                    } else {
                        echo "Error al actualizar la contraseña.";
                    }
                } else {
                    echo "La nueva contraseña y la confirmación no coinciden.";
                }
            } else {
                echo "La contraseña actual es incorrecta.";
            }
        } else {
            echo "Usuario no encontrado.";
        }

        $stmt->close();
        $stmt_update->close();
    }
} else {
    // Si no se recibieron los datos del formulario por el método POST, redirigir a la página de inicio
    header("Location: index.html");
    exit();
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
