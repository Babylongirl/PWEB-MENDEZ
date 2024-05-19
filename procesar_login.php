<?php
// Incluir el archivo de conexión a la base de datos
require_once 'conexion.php';

// Verificar si se recibieron los datos del formulario por el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

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
        if ($contrasena == '' || password_verify($contrasena, $usuario['ContrasenaUsuario'])) {
            // La contraseña es correcta, iniciar sesión y redirigir al usuario a la página correspondiente según su rol
            session_start();
            $_SESSION['usuario_id'] = $usuario['IdUsuario'];
            $_SESSION['usuario_nombre'] = $usuario['NombreUsuario'];
            // Puedes agregar más datos de usuario a la sesión si lo deseas

            // Redirigir al usuario según su rol
            if ($usuario['IdRol'] == 1) {
                // Si el rol es 1, redirigir al usuario a la página de clientes
                header("Location: indexcliente.php");
            } elseif ($usuario['IdRol'] == 2) {
                // Si el rol es 2, redirigir al usuario a la página de administradores
                header("Location: indexadmin.php");
            }
            exit();
        } else {
            // La contraseña es incorrecta, mostrar un mensaje de error
            echo "<script>alert('Credenciales inválidas.'); window.location.href='login.php';</script>";
            exit();
        }
    } else {
        // No se encontró ningún usuario con el correo electrónico proporcionado, mostrar un mensaje de error
        echo "<script>alert('Credenciales inválidas.'); window.location.href='login.php';</script>";
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
