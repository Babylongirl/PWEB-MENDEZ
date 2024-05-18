<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta</title>
    <link rel="stylesheet" type="text/css" href="CSS/csscrearcuenta.css">
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
                <li><a href="contactanos.php">Contáctanos</a></li>
                <li><a href="catalogo.php">Catálogo</a></li>
                <?php
                session_start();
                if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['rol'])) {
                    // Si el usuario no ha iniciado sesión, mostrar los botones de "Login" y "Crear Cuenta"
                    echo '<li><a href="crear cuenta.php">Crear Cuenta</a></li>';
                    echo '<li><a href="login.php">Login</a></li>';
                }
                ?>
            </ul>
        </nav>
        
    </header><hr/>
    
    <h2>Crea tu cuenta con nosotros</h2>
    <p>En unos simples pasos...</p>
    
    
    <div class="container">
        <div class="image-container">
            <img src="IMAGEN/escudo.jpg" alt="Imagen">
        </div>
        <div class="form-container">
            <form action="procesar_cuenta.php" method="post">
                <!-- Información personal -->
                <label for="nombre">Nombre Completo:</label><br>
                <input type="text" id="nombre" name="nombre" required><br>
                <label for="celular">Celular:</label><br>
                <input type="tel" id="celular" name="celular" required><br>
                
                <!-- Información de la cuenta -->
                <label for="correo">Correo electrónico:</label><br>
                <input type="email" id="correo" name="correo" required><br>
                <label for="contrasena">Contraseña:</label><br>
                <input type="password" id="contrasena" name="contrasena" required><br><br>
                
                <!-- Botones -->
                <button type="button" onclick="cancelar()">Cancelar</button>
                <button type="submit">Guardar</button>
            </form>
        </div>
    </div>
    
    <script>
        function cancelar() {
            // Redirigir a la página de inicio o a donde quieras
            window.location.href = "index.html";
        }
    </script>
</body>
</html>
