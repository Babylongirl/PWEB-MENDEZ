<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" type="text/css" href="CSS/csslogin.css">
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
                <li><a href="crear cuenta.php">Crear Cuenta</a></li>
                <li><a href="login.php">Login</a></li>
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

    <script>
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
