<?php
include 'conexion.php';

// Verifica si se ha enviado el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = $_POST['IdProducto'];
    $nombre = $_POST['NombreProducto'];
    $descripcion = $_POST['DescripcionProducto'];
    $precio = $_POST['PrecioProducto'];
    $categoria = $_POST['IdCategoria'];

    // Verifica si se ha subido una nueva imagen
    if ($_FILES['ImagenProducto']['size'] > 0) {
        $imagen = addslashes(file_get_contents($_FILES['ImagenProducto']['tmp_name']));
        // Actualiza los datos del producto con la nueva imagen
        $query = "UPDATE producto SET NombreProducto='$nombre', DescripcionProducto='$descripcion', PrecioProducto='$precio', ImagenProducto='$imagen', IdCategoria='$categoria' WHERE IdProducto='$id'";
    } else {
        // Actualiza los datos del producto sin cambiar la imagen
        $query = "UPDATE producto SET NombreProducto='$nombre', DescripcionProducto='$descripcion', PrecioProducto='$precio', IdCategoria='$categoria' WHERE IdProducto='$id'";
    }
    
    $result = $conn->query($query);
    if ($result) {
        echo "<script>alert('Producto actualizado con éxito'); window.location.href='productoscrud.php';</script>";
    } else {
        echo "Error al actualizar producto: " . $conn->error;
    }
}

// Obtiene los datos del producto a editar
if (isset($_POST['IdProducto'])) {
    $id = $_POST['IdProducto'];
    $query = "SELECT * FROM producto WHERE IdProducto='$id'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre = $row['NombreProducto'];
        $descripcion = $row['DescripcionProducto'];
        $precio = $row['PrecioProducto'];
        $idCategoria = $row['IdCategoria'];
    } else {
        echo "Producto no encontrado.";
        exit;
    }
} else {
    echo "ID de producto no proporcionado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Editar Producto</h1>
        <form action="editar_producto.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="IdProducto" value="<?php echo $id; ?>">
            <div class="mb-3">
                <label for="NombreProducto" class="form-label">Nombre:</label>
                <input type="text" id="NombreProducto" name="NombreProducto" value="<?php echo $nombre; ?>" required class="form-control">
            </div>
            <div class="mb-3">
                <label for="DescripcionProducto" class="form-label">Descripción:</label>
                <textarea id="DescripcionProducto" name="DescripcionProducto" required class="form-control"><?php echo $descripcion; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="PrecioProducto" class="form-label">Precio:</label>
                <input type="number" id="PrecioProducto" name="PrecioProducto" step="0.01" value="<?php echo $precio; ?>" required class="form-control">
            </div>
            <div class="mb-3">
                <label for="ImagenProducto" class="form-label">Imagen:</label>
                <input type="file" id="ImagenProducto" name="ImagenProducto" class="form-control">
            </div>
            <div class="mb-3">
                <label for="IdCategoria" class="form-label">Categoría:</label>
                <select id="IdCategoria" name="IdCategoria" required class="form-control">
                    <option value="">Seleccione una categoría</option>
                    <?php
                    // Consulta para obtener las categorías disponibles
                    $sql = "SELECT IdCategoria, DescripcionCategoria FROM categoria";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        $selected = ($row["IdCategoria"] == $idCategoria) ? 'selected' : '';
                        echo "<option value='" . $row["IdCategoria"] . "' $selected>" . $row["DescripcionCategoria"] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Producto</button>
            <a href="productoscrud.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
