<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Inicializar la variable para el mensaje
$mensaje = "";

// Verificar si se recibió una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se recibió el ID del producto y la nueva cantidad
    if(isset($_POST['producto_id']) && isset($_POST['cantidad'])) {
        // Obtener el ID del producto y la nueva cantidad desde el formulario
        $producto_id = $_POST['producto_id'];
        $nueva_cantidad = $_POST['cantidad'];

        // Iniciar la sesión para obtener el ID del usuario
        session_start();

        // Verificar si el ID de usuario está presente en la sesión
        if(isset($_SESSION['usuario_id'])) {
            // Obtener el ID del usuario de la sesión
            $id_usuario = $_SESSION['usuario_id'];

            // Consulta para actualizar la cantidad del producto en el carrito
            $sql_actualizar = "UPDATE carrito SET Cantidad = ? WHERE IdUsuario = ? AND IdProducto = ?";
            
            // Preparar la consulta
            $stmt = $conn->prepare($sql_actualizar);
            if ($stmt) {
                // Vincular los parámetros
                $stmt->bind_param("iii", $nueva_cantidad, $id_usuario, $producto_id);

                // Ejecutar la consulta
                if ($stmt->execute()) {
                    // Establecer el mensaje de éxito
                    $mensaje = "Producto actualizado exitosamente.";
                } else {
                    echo "Error al actualizar la cantidad del producto en el carrito: " . $conn->error;
                }

                // Cerrar la consulta preparada
                $stmt->close();
            } else {
                echo "Error en la preparación de la consulta.";
            }
        } else {
            // Si no se encuentra el ID de usuario en la sesión, mostrar un mensaje de error
            echo "Error: Usuario no autenticado.";
        }
    } else {
        // Si no se recibió el ID del producto o la nueva cantidad, mostrar un mensaje de error
        echo "Error: Datos incompletos.";
    }
} else {
    // Si no se recibió una solicitud POST, mostrar un mensaje de error
    echo "Error: Solicitud no válida.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Cantidad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Actualizar Cantidad</h1>
        <?php if (!empty($mensaje)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        <a href="crudcarrito.php" class="btn btn-primary">Volver al Carrito</a>
    </div>
</body>
</html>
