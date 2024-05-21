<!DOCTYPE html>
<html lang="es">
  <head>
      <meta charset="utf-8"/>
      <title>Contáctanos</title>
      <link rel="stylesheet" type="text/css" href="CSS/csscontactanos.css"/>
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
  </header>
  <hr/>
  <main>
    <!-- Contenido principal de la página -->
    <div class="container">
    <img src="IMAGEN/CONTACTENOS.jpg" alt="Imagen ajustada a la pantalla">
    </div>
    <div class="container2">
        <h1>Póngase en contacto</h1>
        <div class="contact-info">
            <div class="whatsapp">
                <img src="IMAGEN/whatsapp.png" alt="WhatsApp">
                <a href="tel:+528118299334">+52 81 1829 9334</a>
            </div>
            <p class="rojo">------------------------------------</p>
            <p><strong>Horario de atención a cliente:</strong></p>
            <p>Lunes a Viernes de 8:00 am a 6:00 pm</p>
            <p class="rojo">------------------------------------</p>
            <div class="contact-info">
                <div class="mensaje">
                    <img src="IMAGEN/mensaje.png" alt="Mensaje">
                    <p><a href="mailto:mendez@aislamientosyrefractarios.com">mendez@aislamientosyrefractarios.com</a></p>
                </div>
            </div>
        </div>
    </div>

        <div class="container">
            <img src="IMAGEN/necesita.png" alt="Imagen ajustada a la pantalla">
        </div>
        <div class="container3">
            <h2>¿Dónde nos ubicamos?</h2>
            <div class="underline"></div>
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3732.2389445055954!2d-100.24342628457274!3d20.695717986187687!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x842cb62e1b0e84e1%3A0x63a6f9b4b61b7d1a!2sAv.%20Central%20230%2C%20Interior%20121%2C%20Los%20Lermas%2C%2067188%20Guadalupe%2C%20N.L.%2C%20M%C3%A9xico!5e0!3m2!1ses!2sus!4v1621302300020!5m2!1ses!2sus" 
                    allowfullscreen="" 
                    loading="lazy"></iframe>
            </div>
        </div>
</main>
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
