<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Iniciar sesión
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    // Si el usuario no está autenticado, redirigir al formulario de inicio de sesión
    header("Location: login.php");
    exit();
}

// Inicializar $stmt_update
$stmt_update = null;

// Manejar el cambio de contraseña
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $usuario_id = $_SESSION['usuario_id'];
    $nueva_contrasena = $_POST["nueva_contrasena"];
    $confirmar_contrasena = $_POST["confirmar_contrasena"];

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
            $error_message = "Error al actualizar la contraseña.";
        }
    } else {
        $error_message = "La nueva contraseña y la confirmación no coinciden.";
    }

    // Si $stmt_update se inicializó, entonces ciérralo
    if ($stmt_update) {
        $stmt_update->close();
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Configuración de Cliente</title>
    <link rel="stylesheet" href="CSS/estilos.css"> <!-- Ajusta la ruta y nombre del archivo CSS según tu estructura de directorios -->
</head>
<body>
    <!-- Aquí va el contenido HTML de tu página de configuración -->
    <div class="container">
        <h1>Configuración de Cliente</h1>
        <?php if (isset($error_message)) : ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="nueva_contrasena">Nueva Contraseña:</label><br>
            <input type="password" id="nueva_contrasena" name="nueva_contrasena" required><br><br>
            <label for="confirmar_contrasena">Confirmar Contraseña:</label><br>
            <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required><br><br>
            <input type="submit" value="Cambiar Contraseña">
        </form>
    </div>
</body>
</html>
