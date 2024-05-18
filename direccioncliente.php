<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$mensaje = "";

// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "revision3");

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Manejar la acción CRUD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['crear'])) {
        // Crear dirección
        $calle = $_POST['calle'];
        $colonia = $_POST['colonia'];
        $ciudad = $_POST['ciudad'];
        $codigo_postal = $_POST['codigo_postal'];

        $sql = "INSERT INTO direccion (Calle, Colonia, IdCiudad, CodigoPostal, IdUsuario) VALUES ('$calle', '$colonia', '$ciudad', '$codigo_postal', '$usuario_id')";
        if ($conn->query($sql) === TRUE) {
            $mensaje = "Dirección creada exitosamente.";
        } else {
            $mensaje = "Error al crear la dirección: " . $conn->error;
        }
    } elseif (isset($_POST['actualizar'])) {
        // Actualizar dirección
        $id_direccion = $_POST['id_direccion'];
        $calle = $_POST['calle'];
        $colonia = $_POST['colonia'];
        $ciudad = $_POST['ciudad'];
        $codigo_postal = $_POST['codigo_postal'];

        $sql = "UPDATE direccion SET Calle='$calle', Colonia='$colonia', IdCiudad='$ciudad', CodigoPostal='$codigo_postal' WHERE IdDireccion='$id_direccion' AND IdUsuario='$usuario_id'";
        if ($conn->query($sql) === TRUE) {
            $mensaje = "Dirección actualizada exitosamente.";
        } else {
            $mensaje = "Error al actualizar la dirección: " . $conn->error;
        }
    } elseif (isset($_POST['eliminar'])) {
        // Eliminar dirección
        $id_direccion = $_POST['id_direccion'];

        $sql = "DELETE FROM direccion WHERE IdDireccion='$id_direccion' AND IdUsuario='$usuario_id'";
        if ($conn->query($sql) === TRUE) {
            $mensaje = "Dirección eliminada exitosamente.";
        } else {
            $mensaje = "Error al eliminar la dirección: " . $conn->error;
        }
    }
}

// Obtener todas las direcciones del usuario
$sql = "SELECT d.IdDireccion, d.Calle, d.Colonia, c.NombreCiudad, d.CodigoPostal FROM direccion d JOIN ciudad c ON d.IdCiudad = c.IdCiudad WHERE d.IdUsuario = '$usuario_id'";
$result = $conn->query($sql);

// Obtener todas las ciudades
$sql_ciudades = "SELECT * FROM ciudad";
$result_ciudades = $conn->query($sql_ciudades);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direcciones de Envío</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
        }
        .container {
            margin-top: 20px;
        }
        .btn-volver {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Gestión de Direcciones de Envío</h1>
    </header>
    <div class="container">
        <div class="alert alert-info"><?php echo $mensaje; ?></div>
        
        <h2>Crear Nueva Dirección</h2>
        <form method="post">
            <div class="mb-3">
                <label for="calle" class="form-label">Calle:</label>
                <input type="text" id="calle" name="calle" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="colonia" class="form-label">Colonia:</label>
                <input type="text" id="colonia" name="colonia" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="ciudad" class="form-label">Ciudad:</label>
                <select id="ciudad" name="ciudad" class="form-control" required>
                    <?php while ($row = $result_ciudades->fetch_assoc()) { ?>
                        <option value="<?php echo $row['IdCiudad']; ?>"><?php echo $row['NombreCiudad']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="codigo_postal" class="form-label">Código Postal:</label>
                <input type="text" id="codigo_postal" name="codigo_postal" class="form-control" required>
            </div>
            <button type="submit" name="crear" class="btn btn-primary">Crear Dirección</button>
        </form>

        <h2 class="mt-5">Mis Direcciones</h2>
        <?php if ($result->num_rows > 0) { ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Calle</th>
                        <th>Colonia</th>
                        <th>Ciudad</th>
                        <th>Código Postal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['Calle']; ?></td>
                            <td><?php echo $row['Colonia']; ?></td>
                            <td><?php echo $row['NombreCiudad']; ?></td>
                            <td><?php echo $row['CodigoPostal']; ?></td>
                            <td>
                                <button class="btn btn-secondary" onclick="editarDireccion('<?php echo $row['IdDireccion']; ?>', '<?php echo $row['Calle']; ?>', '<?php echo $row['Colonia']; ?>', '<?php echo $row['NombreCiudad']; ?>', '<?php echo $row['CodigoPostal']; ?>')">Editar</button>
                                <form method="post" style="display:inline-block;">
                                    <input type="hidden" name="id_direccion" value="<?php echo $row['IdDireccion']; ?>">
                                    <button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No tienes direcciones guardadas.</p>
        <?php } ?>

        <a href="menucliente.php" class="btn btn-secondary btn-volver">Volver</a>
    </div>

    <div id="modal-editar" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Dirección</h5>
                    <button type="button" class="btn-close" onclick="cerrarModal()"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <input type="hidden" id="id_direccion" name="id_direccion">
                        <div class="mb-3">
                            <label for="editar_calle" class="form-label">Calle:</label>
                            <input type="text" id="editar_calle" name="calle" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editar_colonia" class="form-label">Colonia:</label>
                            <input type="text" id="editar_colonia" name="colonia" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editar_ciudad" class="form-label">Ciudad:</label>
                            <select id="editar_ciudad" name="ciudad" class="form-control" required>
                                <?php
                                $result_ciudades->data_seek(0); // Reset pointer to beginning
                                while ($row = $result_ciudades->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['IdCiudad']; ?>"><?php echo $row['NombreCiudad']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editar_codigo_postal" class="form-label">Código Postal:</label>
                            <input type="text" id="editar_codigo_postal" name="codigo_postal" class="form-control" required>
                        </div>
                        <button type="submit" name="actualizar" class="btn btn-primary">Actualizar Dirección</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function editarDireccion(id, calle, colonia, ciudad, codigo_postal) {
            document.getElementById('id_direccion').value = id;
            document.getElementById('editar_calle').value = calle;
            document.getElementById('editar_colonia').value = colonia;
            document.getElementById('editar_ciudad').value = ciudad;
            document.getElementById('editar_codigo_postal').value = codigo_postal;
            document.getElementById('modal-editar').style.display = 'block';
        }

        function cerrarModal() {
            document.getElementById('modal-editar').style.display = 'none';
        }
    </script>
</body>
</html>
