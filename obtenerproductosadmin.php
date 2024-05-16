<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Consulta SQL para obtener los datos de los productos
$sql = "SELECT NombreProducto, ImagenProducto, PrecioProducto, CantidadProducto FROM producto";
$resultado = $conn->query($sql);

$productos = array();

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    // Recorrer los resultados y almacenarlos en un array
    while ($fila = $resultado->fetch_assoc()) {
        $producto = array(
            "NombreProducto" => $fila["NombreProducto"],
            "ImagenProducto" => $fila["ImagenProducto"],
            "PrecioProducto" => $fila["PrecioProducto"],
            "CantidadProducto" => $fila["CantidadProducto"]
        );
        $productos[] = $producto;
    }
}

// Cerrar la conexión
$conn->close();

// Agregar un var_dump para verificar los datos antes de devolverlos
var_dump($productos);

// Devolver los datos en formato JSON
echo json_encode($productos);
?>
