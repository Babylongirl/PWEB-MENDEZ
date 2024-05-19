<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Venta</title>
    <link rel="stylesheet" type="text/css" href="CSS/tu_estilo.css">
    <style>
        /* Estilos CSS para la página */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        .btn-volver {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn-volver:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <header>
        <h1>Detalle de Venta</h1>
    </header>

    <div class="container">
        <h2>Detalle de Venta</h2>
        <?php
        // Verificar si se recibió el ID de la venta
        if (isset($_GET['id'])) {
            // Obtener el ID de la venta
            $id_venta = $_GET['id'];

            // Incluir el archivo de conexión a la base de datos
            require_once 'conexion.php';

            // Consulta para obtener los detalles de la venta
            $sql = "SELECT vd.*, p.NombreProducto 
                    FROM ventadetalle vd 
                    INNER JOIN producto p ON vd.IdProducto = p.IdProducto 
                    WHERE vd.IdVenta = $id_venta";
            $result = $conn->query($sql);

            // Verificar si hay resultados
            if ($result->num_rows > 0) {
                // Mostrar la tabla con los detalles de la venta
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Producto</th>";
                echo "<th>Cantidad</th>";
                echo "<th>Precio Unitario</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["NombreProducto"] . "</td>";
                    echo "<td>" . $row["CantidadVentaDetalle"] . "</td>";
                    echo "<td>" . $row["PrecioProducto"] . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "No se encontraron detalles para esta venta.";
            }

            // Cerrar la conexión a la base de datos
            $conn->close();
        } else {
            echo "No se proporcionó un ID de venta.";
        }
        ?>
        <a href="reportesadmin.php" class="btn-volver">Volver</a>
    </div>
</body>
</html>
