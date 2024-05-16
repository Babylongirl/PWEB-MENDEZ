<?php
include 'conexion.php';

// Verificar si se recibió una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se recibió el ID del producto
    if(isset($_POST['producto_id'])) {
        // Obtener el ID del producto desde el formulario
        $producto_id = $_POST['producto_id'];
        
        // Iniciar la sesión para obtener el ID del usuario
        session_start();
        
        // Verificar si el ID de usuario está presente en la sesión
        if(isset($_SESSION['usuario_id'])) {
            // Obtener el ID del usuario de la sesión
            $id_usuario = $_SESSION['usuario_id'];
            echo "ID de usuario en la sesión: " . $id_usuario . "<br>";
            
            // Establecer la cantidad (puedes modificar esto según tus necesidades)
            $cantidad = 1;
            
            // Obtener la fecha actual
            $fecha_carrito = date("Y-m-d");

            // Verificar si el producto ya existe en el carrito del usuario
            $sql_verificar = "SELECT * FROM carrito WHERE IdUsuario = '$id_usuario' AND IdProducto = '$producto_id'";
            $result_verificar = $conn->query($sql_verificar);
            
            // Verificar si se encontró alguna fila en la consulta
            if ($result_verificar->num_rows > 0) {
                echo "El producto ya está en tu carrito.";
            } else {
                // Consulta para obtener el precio del producto
                $sql_precio = "SELECT PrecioProducto FROM producto WHERE IDProducto = $producto_id";
                $result_precio = $conn->query($sql_precio);
                
                // Verificar si se encontró el precio del producto
                if ($result_precio->num_rows > 0) {
                    // Obtener el precio del producto
                    $row_precio = $result_precio->fetch_assoc();
                    $precio_producto = $row_precio["PrecioProducto"];

                    // Insertar el producto en el carrito
                    $sql_insert = "INSERT INTO carrito (IdUsuario, IdProducto, Cantidad, FechaCarrito, PrecioProducto) VALUES ('$id_usuario', '$producto_id', '$cantidad', '$fecha_carrito', '$precio_producto')";
                    
                    // Ejecutar la consulta de inserción
                    if ($conn->query($sql_insert) === TRUE) {
                        echo "Producto agregado al carrito exitosamente.";
                    } else {
                        echo "Error al agregar el producto al carrito: " . $conn->error;
                    }
                } else {
                    echo "No se encontró el precio del producto.";
                }
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
?>
