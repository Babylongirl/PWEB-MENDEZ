<?php
session_start(); // Iniciar sesión

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['usuario_nombre'])) {
    // Si el usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
    header("Location: login.html");
    exit();
}

// Incluir el archivo de conexión
include 'conexion.php';

// Obtener el ID del usuario de la sesión
$usuario_id = $_SESSION['usuario_id'];

// Consulta para obtener los detalles de ventas del usuario, junto con la información del producto, y el total del pedido
$sql = "
SELECT 
    p.NombreProducto,
    vd.CantidadVentaDetalle,
    v.FechaVenta,
    (vd.CantidadVentaDetalle * vd.PrecioProducto) AS VentaTotal
FROM 
    ventadetalle vd
JOIN 
    producto p ON vd.IdProducto = p.IdProducto
JOIN 
    venta v ON vd.IdVenta = v.IdVenta
WHERE 
    v.IdUsuario = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes de Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn-back {
            display: block;
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Reportes de Ventas</h1>
    <table>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Fecha de Compra</th>
            <th>Total de la Venta</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Mostrar datos de cada fila
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["NombreProducto"] . "</td>";
                echo "<td>" . $row["CantidadVentaDetalle"] . "</td>";
                echo "<td>" . $row["FechaVenta"] . "</td>";
                echo "<td>" . $row["VentaTotal"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No se encontraron resultados</td></tr>";
        }
        $conn->close();
        ?>
    </table>
    <a href="menucliente.php" class="btn-back">Volver al Menú</a>
</body>
</html>
