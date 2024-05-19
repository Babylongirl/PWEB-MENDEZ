<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['usuario_id'];

$sql_productos = "SELECT c.IdProducto, p.NombreProducto, p.ImagenProducto, c.Cantidad, c.PrecioProducto, p.PrecioProducto AS PrecioUnitario
        FROM carrito c
        INNER JOIN producto p ON c.IdProducto = p.IdProducto
        WHERE c.IdUsuario = ?";
$stmt_productos = $conn->prepare($sql_productos);
$stmt_productos->bind_param("i", $userId);
$stmt_productos->execute();
$result_productos = $stmt_productos->get_result();

$totalCarrito = 0;
$productos = [];
while ($row = $result_productos->fetch_assoc()) {
    $totalProducto = $row["Cantidad"] * $row["PrecioUnitario"];
    $totalCarrito += $totalProducto;
    $row["TotalProducto"] = $totalProducto;
    $productos[] = $row;
}
$stmt_productos->close();

$stmt_tarjetas = $conn->prepare("SELECT IdUsuarioMetodoPago, SUBSTRING(NumeroCuenta, -4) AS UltimosCuatro FROM usuariometodopago WHERE IdUsuario = ?");
$stmt_tarjetas->bind_param("i", $userId);
$stmt_tarjetas->execute();
$result_tarjetas = $stmt_tarjetas->get_result();

$stmt_direcciones = $conn->prepare("SELECT IdDireccion, CONCAT(Calle, ', ', Colonia, ', CP ', CodigoPostal) AS DireccionCompleta FROM direccion WHERE IdUsuario = ?");
$stmt_direcciones->bind_param("i", $userId);
$stmt_direcciones->execute();
$result_direcciones = $stmt_direcciones->get_result();

$stmt_envios = $conn->prepare("SELECT IdMetodoEnvio, NombreEnvio FROM metodoenvio");
$stmt_envios->execute();
$result_envios = $stmt_envios->get_result();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1, h2, h3 {
            text-align: center;
        }

        .producto {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .producto h3 {
            margin-top: 0;
            color: #007bff;
        }

        .producto img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .total-carrito {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
            text-align: center;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            margin-top: 10px;
            background-color: #007bff;
            color: #fff;
        }

        a.btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            margin-top: 10px;
            text-decoration: none;
            color: #fff;
            background-color: orange;
        }

        a.btn:hover, button:hover {
            opacity: 0.8;
        }
    </style>


</head>
<body>
    <main>
        <div class="container">
            <h1>Resumen del Carrito</h1>
            <?php foreach ($productos as $producto): ?>
            <div class="producto">
                <h3><?php echo $producto["NombreProducto"]; ?></h3>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($producto['ImagenProducto']); ?>" alt="<?php echo $producto["NombreProducto"]; ?>">
                <p>Cantidad: <?php echo $producto["Cantidad"]; ?></p>
                <p>Precio Unitario: $<?php echo number_format($producto["PrecioUnitario"], 2); ?></p>
                <p>Total Producto: $<?php echo number_format($producto["TotalProducto"], 2); ?></p>
            </div>
            <?php endforeach; ?>
            <div class="total-carrito">
                <h3>Total del Carrito: $<?php echo number_format($totalCarrito, 2); ?></h3>
            </div>
            <div style="text-align: center; margin-top: 20px;">
                <h2>Seleccione una dirección:</h2>
                <form action="procesar_pago.php" method="post">
                    <select name="direccion" required>
                        <option value="" selected disabled>Seleccione una dirección</option>
                        <?php while ($row_direccion = $result_direcciones->fetch_assoc()): ?>
                        <option value="<?php echo $row_direccion["IdDireccion"]; ?>"><?php echo $row_direccion["DireccionCompleta"]; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <h2>Seleccione un método de envío:</h2>
                    <select name="envio" required>
                        <option value="" selected disabled>Seleccione un método de envío</option>
                        <?php while ($row_envio = $result_envios->fetch_assoc()): ?>
                        <option value="<?php echo $row_envio["IdMetodoEnvio"]; ?>"><?php echo $row_envio["NombreEnvio"]; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <h2>Seleccione una tarjeta:</h2>
                    <select name="tarjeta" required>
                        <option value="" selected disabled>Seleccione una tarjeta
                        </option>
                        <?php while ($row_tarjeta = $result_tarjetas->fetch_assoc()): ?>
                        <option value="<?php echo $row_tarjeta["IdUsuarioMetodoPago"]; ?>">**** **** **** <?php echo $row_tarjeta["UltimosCuatro"]; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <button type="submit" class="btn btn-success">Pagar</button>
                </form>
                <a href="menucliente.php" class="btn btn-orange">Volver</a>
            </div>
        </div>
    </main>
</body>
</html>

<?php
$stmt_tarjetas->close();
$stmt_direcciones->close();
$stmt_envios->close();
$conn->close();
?>
