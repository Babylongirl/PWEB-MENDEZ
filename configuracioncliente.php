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
    <link rel="stylesheet" href="CSS/estilos.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    width: 50%;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    border-radius: 8px;
}

h1 {
    background-color: #007bff;
    color: white;
    padding: 10px;
    border-radius: 8px 8px 0 0;
    margin: -20px -20px 20px -20px;
    text-align: center;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 10px;
    font-weight: bold;
}

input[type="password"] {
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input[type="submit"] {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

a.btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #6c757d;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    text-align: center;
    text-decoration: none;
}

a.btn.volver {
    background-color: #6c757d;
}

a.btn.volver:hover {
    background-color: #5a6268;
}

.error {
    background-color: #f8d7da;
    color: #721c24;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #f5c6cb;
    border-radius: 4px;
}

        </style>
</head>
<body>
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
        <a href="menucliente.php" class="btn volver">Volver</a>
    </div>
</body>
</html>
