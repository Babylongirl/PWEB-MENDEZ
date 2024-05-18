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
        // Crear método de pago
        $id_metodo_pago = $_POST['id_metodo_pago'];
        $proveedor = $_POST['proveedor'];
        $numero_cuenta = $_POST['numero_cuenta'];
        $fecha_expiracion = $_POST['fecha_expiracion'];
        $es_predeterminada = isset($_POST['es_predeterminada']) ? 1 : 0;

        if ($es_predeterminada) {
            // Desmarcar cualquier método predeterminado anterior
            $sql = "UPDATE usuariometodopago SET EsPredeterminada=0 WHERE IdUsuario='$usuario_id'";
            $conn->query($sql);
        }

        $sql = "INSERT INTO usuariometodopago (IdUsuario, IdMetodoPago, Proveedor, NumeroCuenta, FechaExpiracion, EsPredeterminada, Activo) VALUES ('$usuario_id', '$id_metodo_pago', '$proveedor', '$numero_cuenta', '$fecha_expiracion', '$es_predeterminada', 1)";
        if ($conn->query($sql) === TRUE) {
            $mensaje = "Método de pago creado exitosamente.";
        } else {
            $mensaje = "Error al crear el método de pago: " . $conn->error;
        }
    } elseif (isset($_POST['actualizar'])) {
        // Actualizar método de pago
        $id_usuario_metodo_pago = $_POST['id_usuario_metodo_pago'];
        $id_metodo_pago = $_POST['id_metodo_pago'];
        $proveedor = $_POST['proveedor'];
        $numero_cuenta = $_POST['numero_cuenta'];
        $fecha_expiracion = $_POST['fecha_expiracion'];
        $es_predeterminada = isset($_POST['es_predeterminada']) ? 1 : 0;

        if ($es_predeterminada) {
            // Desmarcar cualquier método predeterminado anterior
            $sql = "UPDATE usuariometodopago SET EsPredeterminada=0 WHERE IdUsuario='$usuario_id'";
            $conn->query($sql);
        }

        $sql = "UPDATE usuariometodopago SET IdMetodoPago='$id_metodo_pago', Proveedor='$proveedor', NumeroCuenta='$numero_cuenta', FechaExpiracion='$fecha_expiracion', EsPredeterminada='$es_predeterminada' WHERE IdUsuarioMetodoPago='$id_usuario_metodo_pago' AND IdUsuario='$usuario_id'";
        if ($conn->query($sql) === TRUE) {
            $mensaje = "Método de pago actualizado exitosamente.";
        } else {
            $mensaje = "Error al actualizar el método de pago: " . $conn->error;
        }
    } elseif (isset($_POST['eliminar'])) {
        // Ocultar método de pago
        $id_usuario_metodo_pago = $_POST['id_usuario_metodo_pago'];

        $sql = "UPDATE usuariometodopago SET Activo=0 WHERE IdUsuarioMetodoPago='$id_usuario_metodo_pago' AND IdUsuario='$usuario_id'";
        if ($conn->query($sql) === TRUE) {
            $mensaje = "Método de pago eliminado exitosamente.";
        } else {
            $mensaje = "Error al eliminar el método de pago: " . $conn->error;
        }
    }
}

// Obtener métodos de pago del usuario
$sql = "SELECT ump.IdUsuarioMetodoPago, ump.IdMetodoPago, mp.NombrePago, ump.Proveedor, ump.NumeroCuenta, ump.FechaExpiracion, ump.EsPredeterminada 
        FROM usuariometodopago AS ump 
        JOIN metodopago AS mp ON ump.IdMetodoPago = mp.IdMetodoPago 
        WHERE IdUsuario='$usuario_id' AND Activo=1";
$result = $conn->query($sql);

// Obtener todos los métodos de pago disponibles
$sql_metodos = "SELECT IdMetodoPago, NombrePago FROM metodopago";
$metodos_pago = $conn->query($sql_metodos);

$metodos_pago_array = [];
while ($row = $metodos_pago->fetch_assoc()) {
    $metodos_pago_array[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Métodos de Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Gestionar Métodos de Pago</h2>
        <p><?php echo $mensaje; ?></p>

        <!-- Formulario de agregar método de pago -->
        <form method="post" action="">
            <div class="mb-3">
                <label for="id_metodo_pago" class="form-label">Método de Pago</label>
                <select class="form-select" name="id_metodo_pago" id="id_metodo_pago" required>
                    <?php foreach ($metodos_pago_array as $row): ?>
                        <option value="<?php echo $row['IdMetodoPago']; ?>"><?php echo $row['NombrePago']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="proveedor" class="form-label">Proveedor</label>
                <input type="text" class="form-control" name="proveedor" id="proveedor" required>
            </div>
            <div class="mb-3">
                <label for="numero_cuenta" class="form-label">Número de Cuenta</label>
                <input type="text" class="form-control" name="numero_cuenta" id="numero_cuenta" maxlength="16" required>
            </div>
            <div class="mb-3">
                <label for="fecha_expiracion" class="form-label">Fecha de Expiración</label>
                <input type="text" class="form-control" name="fecha_expiracion" id="fecha_expiracion" maxlength="5" placeholder="MM/AA" required>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" name="es_predeterminada" id="es_predeterminada">
                <label class="form-check-label" for="es_predeterminada">¿Es Predeterminada?</label>
            </div>
            <button type="submit" name="crear" class="btn btn-primary">Agregar</button>
        </form>

        <!-- Modal para actualizar método de pago -->
        <div class="modal fade" id="actualizarModal" tabindex="-1" aria-labelledby="actualizarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="actualizarModalLabel">Actualizar Método de Pago</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formActualizar" method="post" action="">
                            <input type="hidden" name="id_usuario_metodo_pago" id="actualizar_id_usuario_metodo_pago">
                            <div class="mb-3">
                                <label for="actualizar_id_metodo_pago" class="form-label">Método de Pago</label>
                                <select class="form-select" name="id_metodo_pago" id="actualizar_id_metodo_pago" required>
                                    <!-- Options will be populated by JavaScript -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="actualizar_proveedor" class="form-label">Proveedor</label>
                                <input type="text" class="form-control" name="proveedor" id="actualizar_proveedor" required>
                            </div>
                            <div class="mb-3">
                                <label for="actualizar_numero_cuenta" class="form-label">Número de Cuenta</label>
                                <input type="text" class="form-control" name="numero_cuenta" id="actualizar_numero_cuenta" maxlength="16" required>
                            </div>
                            <div class="mb-3">
                                <label for="actualizar_fecha_expiracion" class="form-label">Fecha de Expiración</label>
                                <input type="text" class="form-control" name="fecha_expiracion" id="actualizar_fecha_expiracion" maxlength="5" placeholder="MM/AA" required>
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" name="es_predeterminada" id="actualizar_es_predeterminada">
                                <label class="form-check-label" for="actualizar_es_predeterminada">¿Es Predeterminada?</label>
                            </div>
                            <button type="submit" name="actualizar" class="btn btn-secondary">Actualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="mt-5">Tus Métodos de Pago</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Método de Pago</th>
                    <th>Proveedor</th>
                    <th>Número de Cuenta</th>
                    <th>Fecha de Expiración</th>
                    <th>Predeterminado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['NombrePago']; ?></td>
                        <td><?php echo $row['Proveedor']; ?></td>
                        <td><?php echo $row['NumeroCuenta']; ?></td>
                        <td><?php echo $row['FechaExpiracion']; ?></td>
                        <td><?php echo $row['EsPredeterminada'] ? 'Sí' : 'No'; ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="abrirActualizarModal(<?php echo $row['IdUsuarioMetodoPago']; ?>, '<?php echo $row['IdMetodoPago']; ?>', '<?php echo $row['Proveedor']; ?>', '<?php echo $row['NumeroCuenta']; ?>', '<?php echo $row['FechaExpiracion']; ?>', <?php echo $row['EsPredeterminada']; ?>)">Editar</button>
                            <form method="post" action="" style="display:inline;">
                                <input type="hidden" name="id_usuario_metodo_pago" value="<?php echo $row['IdUsuarioMetodoPago']; ?>">
                                <button type="submit" name="eliminar" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="menucliente.php" class="btn btn-secondary mt-3">Volver</a>
    </div>

    <script>
        function abrirActualizarModal(id, metodo, proveedor, cuenta, expiracion, predeterminado) {
            var modal = new bootstrap.Modal(document.getElementById('actualizarModal'), {});
            document.getElementById('actualizar_id_usuario_metodo_pago').value = id;
            document.getElementById('actualizar_id_metodo_pago').innerHTML = '<?php foreach ($metodos_pago_array as $row): ?><option value="<?php echo $row['IdMetodoPago']; ?>"><?php echo $row['NombrePago']; ?></option><?php endforeach; ?>';
            document.getElementById('actualizar_id_metodo_pago').value = metodo;
            document.getElementById('actualizar_proveedor').value = proveedor;
            document.getElementById('actualizar_numero_cuenta').value = cuenta;
            document.getElementById('actualizar_fecha_expiracion').value = expiracion;
            document.getElementById('actualizar_es_predeterminada').checked = predeterminado == 1;
            modal.show();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
