<?php
include 'conexion.php';
session_start(); // Iniciamos la sesión para poder acceder a $_SESSION

$precioTotal = $_POST['precioTotal'] ?? 0; // Establecemos un valor predeterminado en caso de que no se reciba 'precioTotal'
$idDireccion = $_POST['direccion'] ?? 0; // Establecemos un valor predeterminado en caso de que no se reciba 'direccion'
$idEnvio = $_POST['envio'] ?? 0; // Establecemos un valor predeterminado en caso de que no se reciba 'envio'
$idTarjeta = $_POST['tarjeta'] ?? 0; // Establecemos un valor predeterminado en caso de que no se reciba 'tarjeta'

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['usuario_id'];

// Insertar una nueva venta en la tabla de ventas
$sql_venta = "INSERT INTO venta (FechaVenta, VentaTotal, IdEstadoVenta, IdUsuario, IdMetodoPago, IdDireccion, IdMetodoEnvio)
VALUES (CURDATE(), ?, 2, ?, ?, ?, ?)";
$stmt_venta = $conn->prepare($sql_venta);
$stmt_venta->bind_param("diiii", $precioTotal, $userId, $idTarjeta, $idDireccion, $idEnvio);
$stmt_venta->execute();
$stmt_venta->close();

// Obtener el ID de la venta recién insertada
$idVenta = $conn->insert_id;

// Insertar los detalles de la venta en la tabla de detalles de venta
$sql_detalle_venta = "INSERT INTO ventadetalle (IdVenta, IdProducto, CantidadVentaDetalle, PrecioProducto)
SELECT ?, c.IdProducto, c.Cantidad, c.PrecioProducto
FROM carrito c
WHERE c.IdUsuario = ?";
$stmt_detalle_venta = $conn->prepare($sql_detalle_venta);
$stmt_detalle_venta->bind_param("ii", $idVenta, $userId);
$stmt_detalle_venta->execute();
$stmt_detalle_venta->close();

// Vaciar el carrito del usuario
$sql_vaciar_carrito = "DELETE FROM carrito WHERE IdUsuario = ?";
$stmt_vaciar_carrito = $conn->prepare($sql_vaciar_carrito);
$stmt_vaciar_carrito->bind_param("i", $userId);
$stmt_vaciar_carrito->execute();
$stmt_vaciar_carrito->close();

$conn->close();

// Redirigir al usuario a una página de confirmación
header("Location: confirmacion_pago.php");
exit;
?>
