<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" type="text/css" href="CSS/csslogin.css">
</head>
<body>
    <header>
        <div class="logo">
          <a href="index.html">
            <img src="IMAGEN/logoEmpresa1.png" alt="Logo de la empresa">
          </a>
        </div>
        <nav>
            <ul>
                <li><a href="nosotros.php">Acerca de nosotros</a></li>
                <li><a href="#contacto">Contáctanos</a></li>
                <li><a href="catalogo.php">Catálogo</a></li>
                <li><a href="crear cuenta.php">Crear Cuenta</a></li>
                <li><a href="login.php">Login</a></li>
                
            </ul>
        </nav>
    </header><hr/>

    <div class="form-container">
        <h2>Inicia sesión con tu cuenta</h2>
        <form action="procesar_login.php" method="post" class="login-form">
            <!-- Campos de inicio de sesión -->
            <label for="correo">Correo electrónico:</label><br>
            <input type="email" id="correo" name="correo" required><br>
            <label for="contrasena">Contraseña:</label><br>
            <input type="password" id="contrasena" name="contrasena" required><br><br>
            
            <!-- Botón de inicio de sesión -->
            <input type="submit" value="Iniciar Sesión">
        </form>
    </div>
</body>
</html>
