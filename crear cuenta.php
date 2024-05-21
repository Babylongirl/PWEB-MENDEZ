<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta</title>
    <link rel="stylesheet" type="text/css" href="CSS/csscrearcuenta.css">
    <style>
        .menu-hamburguesa {
            display: none;
            flex-direction: column;
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 20px;
        }

        .menu-hamburguesa div {
            width: 25px;
            height: 3px;
            background-color: black;
            margin: 4px 0;
            transition: 0.4s;
        }

        .menu-content {
            display: none;
            position: absolute;
            top: 40px;
            right: 20px;
            background-color: white;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .menu-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .menu-content a:hover {
            background-color: #ddd;
        }

        @media (max-width: 768px) {
            nav {
                display: none;
            }

            .menu-hamburguesa {
                display: flex;
            }
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .image-container {
            flex: 1;
            margin-right: 20px;
            max-width: 50%;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
        }

        .form-container {
            flex: 1;
            max-width: 500px;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
        }

        .form-container form label,
        .form-container form input,
        .form-container form button {
            margin-bottom: 10px;
        }

        @media (max-width: 1024px) {
            .container {
                flex-direction: column;
                align-items: center;
            }

            .image-container, .form-container {
                width: 90%;
                margin-bottom: 20px;
            }

            .image-container img {
                width: 100%;
                height: auto;
            }

            .form-container form label,
            .form-container form input,
            .form-container form button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
          <a href="index.php">
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
        <div class="menu-hamburguesa" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="menu-content" id="menuContent">
            <a href="nosotros.php">Acerca de nosotros</a>
            <a href="contactanos.php">Contáctanos</a>
            <a href="catalogo.php">Catálogo</a>
            <a href="crear cuenta.php">Crear Cuenta</a>
            <a href="login.php">Login</a>
        </div>
    </header>
    <hr/>
    
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

        function toggleMenu() {
            var menuContent = document.getElementById('menuContent');
            if (menuContent.style.display === "block") {
                menuContent.style.display = "none";
            } else {
                menuContent.style.display = "block";
            }
        }
    </script>
</body>
</html>
