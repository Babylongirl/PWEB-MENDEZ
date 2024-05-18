<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
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

        .producto p {
            margin: 5px 0;
        }

        .btn-group {
            display: flex;
            align-items: center;
        }

        .btn {
            border-radius: 5px;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-right: 10px; /* Espacio entre botones */
        }

        .btn.btn-primary {
            background-color: #007bff; /* Azul */
            color: #fff;
        }

        .btn.btn-danger {
            background-color: #dc3545; /* Rojo */
            color: #fff;
        }

        .btn.btn-success {
            background-color: #28a745; /* Verde */
            color: #fff;
        }

        .btn.btn-orange {
            background-color: orange; /* Naranja */
            color: #fff;
        }

        .total-carrito {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
            text-align: center; /* Centrar texto */
        }

        input[type=number] {
            width: 60px;
        }

        .container h1 {
            text-align: center; /* Centrar texto */
        }
    </style>
</head>
<body>
    <main>
        <div class="container">
            <h1>Carrito de Compras</h1>
            <?php
            // Include the database connection
            include 'conexion.php';

            // Verificar si el usuario está autenticado y obtener su ID de usuario
            session_start();
            if (isset($_SESSION['usuario_id'])) {
                $userId = $_SESSION['usuario_id'];

                // Query para obtener los productos en el carrito del usuario actual
                $sql = "SELECT c.IdProducto, p.NombreProducto, p.ImagenProducto, c.Cantidad, c.PrecioProducto
                        FROM carrito c
                        INNER JOIN producto p ON c.IdProducto = p.IdProducto
                        WHERE c.IdUsuario = ?";

                // Preparar la consulta
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    // Vincular el parámetro de ID de usuario
                    $stmt->bind_param("i", $userId);

                    // Ejecutar la consulta
                    $stmt->execute();

                    // Obtener el resultado
                    $result = $stmt->get_result();

                    // Cerrar la consulta preparada
                    $stmt->close();
                } else {
                    echo "Error en la preparación de la consulta.";
                }

                // Calcular el total del carrito
                $totalCarrito = 0;
                while ($row = $result->fetch_assoc()) {
                    $totalCarrito += $row["Cantidad"] * $row["PrecioProducto"];
                    echo "<div class='producto'>";
                    echo "<h3>" . $row["NombreProducto"] . "</h3>";
                    echo "<img src='data:image/jpeg;base64," . base64_encode($row['ImagenProducto']) . "' alt='" . $row["NombreProducto"] . "'>";
                    echo "<form action='actualizar_cantidad.php' method='post'>";
                    echo "<input type='hidden' name='producto_id' value='" . $row["IdProducto"] . "'>";
                    echo "<p>Cantidad: <input type='number' name='cantidad' value='" . $row["Cantidad"] . "' min='1'></p>";
                    echo "<p>Total: $" . ($row["Cantidad"] * $row["PrecioProducto"]) . "</p>";
                    echo "<div class='btn-group'>";
                    echo "<button class='btn btn-primary'>Actualizar</button>";
                    echo "</form>";
                    echo "<form action='eliminar_producto_carrito.php' method='post'>";
                    echo "<input type='hidden' name='producto_id' value='" . $row["IdProducto"] . "'>";
                    echo "<button class='btn btn-danger'>Eliminar</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                // Redireccionar a la página de inicio de sesión si el usuario no está autenticado
                header("Location: login.php");
                exit;
            }
            ?>
            <div class="total-carrito">
                Total del Carrito: $<?php echo $totalCarrito; ?>
            </div>
            <div style="text-align: center; margin-top: 20px;">
                <!-- Botón de pagar que redirige a pagar.php -->
                <form action="pagar.php" method="post" style="display: inline;">
                    <button type="submit" class="btn btn-success">Pagar</button>
                </form>
                <!-- Botón de volver que redirige al menú del cliente -->
                <a href="menucliente.php" class="btn btn-orange">Volver</a>
            </div>
        </div>
    </main>
</body>
</html>
