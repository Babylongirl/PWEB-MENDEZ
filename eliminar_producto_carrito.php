<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Definir una variable para almacenar el mensaje
$mensaje = "";

// Verificar si se recibió una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se recibió el ID del producto a eliminar
    if(isset($_POST['producto_id'])) {
        // Obtener el ID del producto desde el formulario
        $producto_id = $_POST['producto_id'];
        
        // Iniciar la sesión para obtener el ID del usuario
        session_start();
        
        // Verificar si el ID de usuario está presente en la sesión
        if(isset($_SESSION['usuario_id'])) {
            // Obtener el ID del usuario de la sesión
            $id_usuario = $_SESSION['usuario_id'];
            
            // Query para eliminar el producto del carrito del usuario actual
            $sql_eliminar = "DELETE FROM carrito WHERE IdUsuario = ? AND IdProducto = ?";
            
            // Preparar la declaración
            $stmt = $conn->prepare($sql_eliminar);
            if ($stmt) {
                // Vincular los parámetros
                $stmt->bind_param("ii", $id_usuario, $producto_id);

                // Ejecutar la declaración
                if ($stmt->execute()) {
                    // Establecer el mensaje de éxito
                    $mensaje = "Producto eliminado exitosamente.";
                    // Redireccionar a crudcarrito.php con un mensaje de éxito
                    header("Location: crudcarrito.php?mensaje=" . urlencode($mensaje));
                    exit();
                } else {
                    echo "Error al eliminar el producto del carrito: " . $stmt->error;
                }

                // Cerrar la declaración
                $stmt->close();
            } else {
                echo "Error en la preparación de la declaración.";
            }
        } else {
            // Si no se encuentra el ID de usuario en la sesión, mostrar un mensaje de error
            echo "Error: Usuario no autenticado.";
        }
    } else {
        // Si no se recibió el ID del producto, mostrar un mensaje de error
        echo "Error: ID del producto no recibido.";
    }
} else {
    // Si no se recibió una solicitud POST, mostrar un mensaje de error
    echo "Error: Solicitud no válida.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
