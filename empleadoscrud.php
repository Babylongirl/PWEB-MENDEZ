<?php
include 'conexion.php'; // Incluye tu archivo de conexión

// Obtiene todos los empleados con el rol de Administrador (IdRol = 2)
$sql = "SELECT * FROM usuario WHERE IdRol = 2";
$result = $conn->query($sql);

// Maneja la adición de un nuevo empleado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $celular = $_POST['celular'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';
    $idRol = 2; // Rol de administrador

    if (empty($nombre) || empty($correo) || empty($celular) || empty($contrasena)) {
        echo "Todos los campos son obligatorios.";
    } else {
        $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT); // Encripta la contraseña

        $sql = "INSERT INTO usuario (NombreUsuario, CorreoUsuario, CelularUsuario, ContrasenaUsuario, IdRol) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }

        $stmt->bind_param("ssssi", $nombre, $correo, $celular, $contrasenaHash, $idRol);

        if ($stmt->execute()) {
            header("Location: empleadoscrud.php");
            exit;
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
        }

        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Empleados</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Gestión de Empleados</h1>
        <a href="menuadmin.php" class="btn btn-secondary mb-3">Volver</a>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Celular</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['IdUsuario']); ?></td>
                    <td><?php echo htmlspecialchars($row['NombreUsuario']); ?></td>
                    <td><?php echo htmlspecialchars($row['CorreoUsuario']); ?></td>
                    <td><?php echo htmlspecialchars($row['CelularUsuario']); ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm editBtn" data-id="<?php echo $row['IdUsuario']; ?>" data-nombre="<?php echo $row['NombreUsuario']; ?>" data-correo="<?php echo $row['CorreoUsuario']; ?>" data-celular="<?php echo $row['CelularUsuario']; ?>">Editar</button>
                        <a href="eliminar_empleado.php?id=<?php echo $row['IdUsuario']; ?>" onclick="return confirm('¿Estás seguro de eliminar este empleado?');" class="btn btn-danger btn-sm">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <h2 class="mt-4">Agregar Empleado</h2>
        <form action="empleadoscrud.php" method="POST" class="mt-3">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" name="correo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="celular">Celular:</label>
                <input type="text" name="celular" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <input type="password" name="contrasena" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
        </form>
    </div>

    <!-- Modal para editar empleado -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Empleado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm">
                    <div class="modal-body">
                        <input type="hidden" id="editId" name="id">
                        <div class="form-group">
                            <label for="editNombre">Nombre:</label>
                            <input type="text" class="form-control" id="editNombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="editCorreo">Correo:</label>
                            <input type="email" class="form-control" id="editCorreo" name="correo" required>
                        </div>
                        <div class="form-group">
                            <label for="editCelular">Celular:</label>
                            <input type="text" class="form-control" id="editCelular" name="celular" required>
                        </div>
                        <div class="form-group">
                            <label for="editContrasena">Nueva Contraseña (dejar en blanco para mantener la actual):</label>
                            <input type="password" class="form-control" id="editContrasena" name="contrasena">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.editBtn').on('click', function() {
            var id = $(this).data('id');
            var nombre = $(this).data('nombre');
            var correo = $(this).data('correo');
            var celular = $(this).data('celular');
            
            $('#editId').val(id);
            $('#editNombre').val(nombre);
            $('#editCorreo').val(correo);
            $('#editCelular').val(celular);
            
            $('#editModal').modal('show');
        });

        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: 'editar_empleado.php',
                data: formData,
                success: function(response) {
                    $('#editModal').modal('hide');
                    location.reload();
                },
                error: function() {
                    alert('Error al actualizar el empleado.');
                }
            });
        });
    });
    </script>
</body>
</html>
