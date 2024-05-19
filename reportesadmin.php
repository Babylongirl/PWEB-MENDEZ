<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
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
        <h1>Reporte de Ventas</h1>
    </header>

    <div class="container">
        <h2>Reporte de Ventas</h2>
        <table>
            <thead>
                <tr>
                    <th>ID de Venta</th>
                    <th>Fecha de Venta</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Incluir el archivo de conexión a la base de datos
                require_once 'conexion.php';

                // Consulta para obtener todas las ventas con sus estados
                $sql = "SELECT v.IdVenta, v.FechaVenta, v.VentaTotal, ev.DescripcionEstadoVenta
                        FROM venta v
                        INNER JOIN estadoventa ev ON v.IdEstadoVenta = ev.IdEstadoVenta";
                $result = $conn->query($sql);

                // Verificar si hay resultados
                if ($result->num_rows > 0) {
                    // Iterar sobre los resultados y mostrar cada venta en una fila de la tabla
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["IdVenta"] . "</td>";
                        echo "<td>" . $row["FechaVenta"] . "</td>";
                        echo "<td>" . $row["VentaTotal"] . "</td>";
                        echo "<td>" . $row["DescripcionEstadoVenta"] . "</td>";
                        echo "<td><a href='detalle_venta.php?id=" . $row["IdVenta"] . "'>Ver Detalle</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No se encontraron ventas.</td></tr>";
                }

                // Cerrar la conexión a la base de datos
                $conn->close();
                ?>
            </tbody>
        </table>
        <a href="menuadmin.php" class="btn-volver">Volver</a>
    </div>
</body>
</html>
