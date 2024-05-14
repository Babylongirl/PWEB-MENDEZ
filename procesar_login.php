<?php
// Incluir el archivo de conexión a la base de datos
require_once 'conexion.php';

// Verificar si se recibieron los datos del formulario por el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    // Encriptar la contraseña ingresada para compararla con la contraseña encriptada almacenada en la base de datos
    $contrasena_encriptada = hash('sha256', $contrasena);

    // Preparar la consulta para seleccionar el usuario con el correo electrónico proporcionado
    $stmt = $conn->prepare("SELECT * FROM usuario WHERE CorreoUsuario = ? LIMIT 1");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró algún usuario con el correo electrónico proporcionado
    if ($result->num_rows == 1) {
        // Obtener los datos del usuario
        $usuario = $result->fetch_assoc();

        // Verificar si la contraseña ingresada coincide con la contraseña almacenada en la base de datos
        if ($usuario['ContrasenaUsuario'] === $contrasena_encriptada) {
            // La contraseña es correcta, iniciar sesión y redirigir al usuario a la página de inicio
            session_start();
            $_SESSION['usuario_id'] = $usuario['IdUsuario'];
            $_SESSION['usuario_nombre'] = $usuario['NombreUsuario'];
            // Puedes agregar más datos de usuario a la sesión si lo deseas

            // Redirigir al usuario a la página de inicio
            header("Location: index.php");
            exit();
        } else {
            // La contraseña es incorrecta, mostrar un mensaje de error
            header("Location: login.html?error=contrasena");
            exit();
        }
    } else {
        // No se encontró ningún usuario con el correo electrónico proporcionado, mostrar un mensaje de error
        header("Location: login.html?error=usuario");
        exit();
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
