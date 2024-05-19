<?php
session_start(); // Iniciar sesión

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['usuario_nombre'])) {
    // Si el usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Méndez-Refractarios y Aislamientos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="CSS/CSS.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #ffffff;
            padding: 10px 20px;
            z-index: 9999;
        }

        main {
            margin-left: 200px; /* Ajustar según el ancho de los botones laterales */
            padding-top: 60px; /* Ajustar según el alto del header */
        }

        .botones-laterales {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0; /* Gris claro */
            padding: 20px;
            z-index: 9998; /* Z-index menor para estar detrás del header */
        }

        .btn-comun {
            width: 150px;
            height: 50px;
            margin-bottom: 20px; /* Espacio entre botones */
            border: none;
            background-color: #007bff; /* Azul */
            color: #fff; /* Texto blanco */
            font-size: 16px;
            border-radius: 25px; /* Mayor radio para un aspecto más redondeado */
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra suave */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn-comun:hover {
            background-color: #0056b3; /* Azul más oscuro al pasar el ratón */
        }

        /* Estilos para el panel derecho */
        .panel-derecho {
            position: fixed;
            top: 0;
            right: 0;
            height: 100vh;
            width: 200px;
            background-color: #f0f0f0; /* Gris claro */
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9997; /* Z-index menor que el del menú lateral */
        }

        .panel-derecho h2 {
            margin-bottom: 20px;
        }

        .panel-derecho img {
            width: 100px; /* Ajusta el tamaño de la foto según necesites */
            height: auto;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        /* Estilos para el menú emergente */
        #menu-emergente {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 9999;
        }

        .menu-opcion {
            margin-bottom: 10px;
            cursor: pointer;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
            background-color: #007bff;
            color: white;
            transition: background-color 0.3s ease;
        }

        .menu-opcion:hover {
            background-color: #0056b3;
        }

        .catalogo {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 20px;
        }

        .producto {
            width: 200px;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            text-align: center;
        }

        .producto img {
            width: 100px;
            height: auto;
            border-radius: 10px;
        }

        .producto p {
            margin: 5px 0;
        }

        .producto button {
            margin-top: 10px;
        }

    </style>
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
                <li><a href="nosotroscliente.php">Acerca de nosotros</a></li>
                <li><a href="contactanoscliente.php">Contáctanos</a></li>
                <li><a href="catalogocliente.php">Catálogo</a></li>
                <li><a href="menucliente.php">Menú</a></li>
            </ul>
        </nav>
    </header>
    <main>
    </main>
    <footer>
        <!-- Botones laterales -->
        <div class="botones-laterales">
            <button class="btn btn-outline-secondary" onclick="alert('Fuera de servicio por el momento')">
                <img src="./IMAGEN/corazon.jpg" alt="Corazón" style="width: 70px; height: 70px; margin-right: 0px;">
            </button>
            <a href="crudcarrito.php" class="btn btn-outline-secondary">
                <img src="./IMAGEN/carrito.jpg" alt="Carrito" style="width: 70px; height: 70px; margin-right: 0px;"></a>
            <button class="btn btn-outline-secondary" onclick="mostrarMenuEmergente()">
            <img src="./IMAGEN/configuracion.jpg" alt="Configuración" style="width: 70px; height: 70px; margin-right: 0px;"></button>
            <button class="btn btn-outline-secondary" id="boton-reportes">
                <img src="./IMAGEN/reportes.jpg" alt="Reportes" style="width: 70px; height: 70px; margin-right: 0px;"></button>
            <button class="btn btn-outline-secondary" id="cerrar-sesion">
                <img src="./IMAGEN/sesion.jpg" alt="Cerrar" style="width: 70px; height: 70px; margin-right: 0px;"></button>
        </div>
    </footer>
    <!-- Panel derecho -->
    <div class="panel-derecho">
        <?php
        // Verificar si el usuario está autenticado
        if(isset($_SESSION['usuario_nombre'])) {
            $nombreUsuario = $_SESSION['usuario_nombre'];
            echo "<h2>$nombreUsuario</h2>";
        } else {
            // Si el usuario no está autenticado, mostrar un mensaje
            echo "<h2>Usuario no identificado</h2>";
        }
        ?>
        <img src="./IMAGEN/fotousuario.jpg" alt="Foto">
        <!-- Cambia 'ruta/a/la/foto.jpg' por la ruta de la foto que desees mostrar -->
    </div>

    <!-- Menú emergente -->
    <div id="menu-emergente">
        <div class="menu-opcion" onclick="redirigir('configuracioncliente.php')">Cambiar contraseña</div>
        <div class="menu-opcion" onclick="redirigir('direccioncliente.php')">Direcciones de envío</div>
        <div class="menu-opcion" onclick="redirigir('metodopagocliente.php')">Mis métodos de pago</div>
    </div>

    <script>
        function mostrarMenuEmergente() {
            document.getElementById('menu-emergente').style.display = 'block';
        }

        function redirigir(url) {
            window.location.href = url;
        }

        // Agregar evento clic al botón "Cerrar Sesión"
        document.getElementById("cerrar-sesion").addEventListener("click", function() {
            // Redireccionar al usuario a cerrar_sesion.php
            window.location.href = "cerrar_sesion.php";
        });

        // Agregar evento clic al botón "Botón Reportes"
        document.getElementById("boton-reportes").addEventListener("click", function() {
            // Redireccionar al usuario a reportescliente.php
            window.location.href = "reportescliente.php";
        });
    </script>
</body>
</html>
