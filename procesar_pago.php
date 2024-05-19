<?php
include 'conexion.php';
session_start();

$idDireccion = $_POST['direccion'] ?? 0; // Dirección seleccionada
$idEnvio = $_POST['envio'] ?? 0; // Método de envío seleccionado
$idUsuarioMetodoPago = $_POST['tarjeta'] ?? 0; // Método de pago del usuario

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['usuario_id'];

// Fetch IdMetodoPago using IdUsuarioMetodoPago
$stmt = $conn->prepare("SELECT IdMetodoPago FROM usuariometodopago WHERE IdUsuarioMetodoPago = ?");
$stmt->bind_param("i", $idUsuarioMetodoPago);
$stmt->execute();
$stmt->bind_result($idMetodoPago);
$stmt->fetch();
$stmt->close();

if (!$idMetodoPago) {
    echo "Método de pago inválido.";
    exit;
}

// Calcular el precio total desde el carrito del usuario
$sql_carrito = "SELECT SUM(c.Cantidad * c.PrecioProducto) AS VentaTotal
                FROM carrito c
                WHERE c.IdUsuario = ?";
$stmt_carrito = $conn->prepare($sql_carrito);
$stmt_carrito->bind_param("i", $userId);
$stmt_carrito->execute();
$stmt_carrito->bind_result($precioTotal);
$stmt_carrito->fetch();
$stmt_carrito->close();

if ($precioTotal <= 0) {
    echo "El carrito está vacío o hubo un error en el cálculo.";
    exit;
}

$conn->begin_transaction();

try {
    // Insertar una nueva venta en la tabla de ventas
    $sql_venta = "INSERT INTO venta (FechaVenta, VentaTotal, IdEstadoVenta, IdUsuario, IdMetodoPago, IdDireccion, IdMetodoEnvio, IVA)
                  VALUES (CURDATE(), ?, 2, ?, ?, ?, ?, ?)";
    $IVA = $precioTotal * 0.16; // Calcular el IVA, ajusta el porcentaje según sea necesario
    $stmt_venta = $conn->prepare($sql_venta);
    $stmt_venta->bind_param("diiiid", $precioTotal, $userId, $idMetodoPago, $idDireccion, $idEnvio, $IVA); // Actualizado para usar 6 parámetros
    if (!$stmt_venta->execute()) {
        throw new Exception($stmt_venta->error);
    }
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
    if (!$stmt_detalle_venta->execute()) {
        throw new Exception($stmt_detalle_venta->error);
    }
    $stmt_detalle_venta->close();

    // Vaciar el carrito del usuario
    $sql_vaciar_carrito = "DELETE FROM carrito WHERE IdUsuario = ?";
    $stmt_vaciar_carrito = $conn->prepare($sql_vaciar_carrito);
    $stmt_vaciar_carrito->bind_param("i", $userId);
    if (!$stmt_vaciar_carrito->execute()) {
        throw new Exception($stmt_vaciar_carrito->error);
    }
    $stmt_vaciar_carrito->close();

    // Commit transaction
    $conn->commit();

    // Redirigir al usuario a menucliente.php con un mensaje de éxito
    echo "<script>
            alert('Gracias por su compra, su pedido será enviado en 5-7 días hábiles');
            window.location.href = 'menucliente.php';
          </script>";
    exit;

} catch (Exception $e) {
    // Rollback transaction
    $conn->rollback();
    echo "Error: " . $e->getMessage();
    $conn->close();
    exit;
}

$conn->close();
?>
