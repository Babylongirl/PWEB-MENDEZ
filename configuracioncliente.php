<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
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

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }

        .success {
            color: #28a745;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Configuración de Cliente</h1>
        <?php
        session_start();
        if (isset($_SESSION['usuario_id'])) {
            $userId = $_SESSION['usuario_id'];
            $error = '';
            $success = '';

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                include 'conexion.php';

                $currentPassword = $_POST['current_password'];
                $newPassword = $_POST['new_password'];
                $confirmPassword = $_POST['confirm_password'];

                if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                    $error = "Todos los campos son obligatorios.";
                } elseif ($newPassword !== $confirmPassword) {
                    $error = "Las nuevas contraseñas no coinciden.";
                } else {
                    $sql = "SELECT ContrasenaUsuario FROM usuario WHERE IdUsuario = ?";
                    $stmt = $conn->prepare($sql);
                    if ($stmt) {
                        $stmt->bind_param("i", $userId);
                        $stmt->execute();
                        $stmt->bind_result($dbPassword);
                        $stmt->fetch();
                        $stmt->close();

                        if (hash('sha256', $currentPassword) !== $dbPassword) {
                            $error = "La contraseña actual es incorrecta.";
                        } else {
                            $newPasswordHashed = hash('sha256', $newPassword);
                            $updateSql = "UPDATE usuario SET ContrasenaUsuario = ? WHERE IdUsuario = ?";
                            $updateStmt = $conn->prepare($updateSql);
                            if ($updateStmt) {
                                $updateStmt->bind_param("si", $newPasswordHashed, $userId);
                                if ($updateStmt->execute()) {
                                    $success = "La contraseña ha sido actualizada correctamente.";
                                } else {
                                    $error = "Error al actualizar la contraseña.";
                                }
                                $updateStmt->close();
                            } else {
                                $error = "Error en la preparación de la consulta de actualización.";
                            }
                        }
                    } else {
                        $error = "Error en la preparación de la consulta.";
                    }

                    $conn->close();
                }
            }
        ?>
        <form method="post" action="configuracioncliente.php">
            <div class="form-group">
                <label for="current_password">Contraseña Actual:</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">Nueva Contraseña:</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirmar Nueva Contraseña:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
                <a href="menucliente.php" class="btn btn-orange">Volver</a>
            </div>
            <?php
            if (!empty($error)) {
                echo "<div class='error'>$error</div>";
            }
            if (!empty($success)) {
                echo "<div class='success'>$success</div>";
            }
            ?>
        </form>
        <?php
        } else {
            header("Location: login.php");
            exit;
        }
        ?>
    </div>
</body>
</html>
