<?php include 'conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 20px;
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
        .buscador {
            margin-bottom: 20px;
        }
        .btn {
            border-radius: 5px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-warning {
            background-color: #ffc107;
        }
    </style>
</head>
<body>
    <a href="menuadmin.php" class="btn btn-secondary mb-3">Volver al Menú</a>
    <h1>Agregar Producto</h1>
    <form action="productoscrud.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="create">
        <label for="NombreProducto">Nombre:</label>
        <input type="text" id="NombreProducto" name="NombreProducto" required class="form-control"><br>
        <label for="DescripcionProducto">Descripción:</label>
        <textarea id="DescripcionProducto" name="DescripcionProducto" required class="form-control"></textarea><br>
        <label for="PrecioProducto">Precio:</label>
        <input type="number" id="PrecioProducto" name="PrecioProducto" step="0.01" required class="form-control"><br>
        <label for="ImagenProducto">Imagen:</label>
        <input type="file" id="ImagenProducto" name="ImagenProducto" required class="form-control"><br>
        <label for="IdCategoria">Categoría:</label>
        <select id="IdCategoria" name="IdCategoria" required class="form-control">
            <option value="">Seleccione una categoría</option>
            <?php
            // Consulta para obtener las categorías disponibles
            $sql = "SELECT IdCategoria, DescripcionCategoria FROM categoria";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()) {
                echo "<option value='".$row["IdCategoria"]."'>".$row["DescripcionCategoria"]."</option>";
            }
            ?>
        </select><br>
        <input type="submit" value="Agregar Producto" class="btn btn-primary">
    </form>

    <h2>Productos Existentes</h2>
    <?php
    // Consulta para obtener los productos existentes
    $sql = "SELECT p.IdProducto, p.NombreProducto, p.DescripcionProducto, p.PrecioProducto, p.ImagenProducto, c.DescripcionCategoria 
            FROM producto p 
            INNER JOIN categoria c ON p.IdCategoria = c.IdCategoria";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='row'>";
        while($row = $result->fetch_assoc()) {
            echo "<div class='col-md-4'>";
            echo "<div class='producto'>";
            echo "<h3>" . $row["NombreProducto"] . "</h3>";
            echo "<img src='data:image/jpeg;base64,".base64_encode($row['ImagenProducto'])."' alt='" . $row["NombreProducto"] . "'>";
            echo "<p>" . $row["DescripcionProducto"] . "</p>";
            echo "<p>Precio: $" . $row["PrecioProducto"] . "</p>";
            echo "<p>Categoría: " . $row["DescripcionCategoria"] . "</p>";
            echo "<div class='d-flex justify-content-between'>";
            echo "<form action='editar_producto.php' method='post' class='d-inline'>";
            echo "<input type='hidden' name='IdProducto' value='" . $row["IdProducto"] . "'>";
            echo "<button type='submit' class='btn btn-warning'>Editar</button>";
            echo "</form>";
            echo "<form action='productoscrud.php' method='post' class='d-inline'>";
            echo "<input type='hidden' name='action' value='delete'>";
            echo "<input type='hidden' name='IdProducto' value='" . $row["IdProducto"] . "'>";
            echo "<button type='submit' class='btn btn-danger'>Eliminar</button>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p>No hay productos disponibles.</p>";
    }
    ?>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    if ($action === 'create') {
        $nombre = $_POST['NombreProducto'];
        $descripcion = $_POST['DescripcionProducto'];
        $precio = $_POST['PrecioProducto'];
        $imagen = addslashes(file_get_contents($_FILES['ImagenProducto']['tmp_name']));
        $categoria = $_POST['IdCategoria'];
        $query = "INSERT INTO producto (NombreProducto, DescripcionProducto, PrecioProducto, ImagenProducto, IdCategoria) 
                  VALUES ('$nombre', '$descripcion', '$precio', '$imagen', '$categoria')";
        $result = $conn->query($query);
        if ($result) {
            echo "<script>alert('Producto creado con éxito'); window.location.href='productoscrud.php';</script>";
        } else {
            echo "Error al crear producto: " . $conn->error;
        }
    } elseif ($action === 'delete') {
        $id = $_POST['IdProducto'];
        $query = "DELETE FROM producto WHERE IdProducto='$id'";
        $result = $conn->query($query);
        if ($result) {
            echo "<script>alert('Producto eliminado con éxito'); window.location.href='productoscrud.php';</script>";
        } else {
            echo "Error al eliminar producto: " . $conn->error;
        }
    }
}
?>
