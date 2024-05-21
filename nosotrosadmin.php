
<!DOCTYPE html>
<html lang="es">
  <head>
      <meta charset="utf-8"/>
      <title>Acerca de nostros </title>
      <link rel="stylesheet" type="text/css" href="CSS/cssnosotros.css"/>
  <style>
    .menu-hamburguesa {
            display: none;
            flex-direction: column;
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 20px;
            z-index: 1000;
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
        <a href="indexadmin.php">
          <img src="IMAGEN/logoEmpresa1.png" alt="Logo de la empresa">
        </a>
      </div>
      <nav>
          <ul>
          <li><a href="nosotrosadmin.php">Acerca de nosotros</a></li>
              <li><a href="contactanosadmin.php">Contáctanos</a></li>
              <li><a href="catalogoadmin.php">Catálogo</a></li>
              <li><a href="menuadmin.php">Menu</a></li>
              

              
          </ul>
      </nav>
      <div class="menu-hamburguesa" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="menu-content" id="menuContent">
            <a href="nosotrosadmin.php">Acerca de nosotros</a>
            <a href="contactanosadmin.php">Contáctanos</a>
            <a href="catalogoadmin.php">Catálogo</a>
            <a href="menuadmin.php">Menu</a>
        </div>
  </header><hr/>
  <main>
    <!-- Contenido principal de la página -->
    <div class="container">
    <img src="IMAGEN/Nosotros.png" alt="Imagen ajustada a la pantalla">
    </div>
    <div class="container1">
      <div class="texto">
        <h5>¿QUIÉNES SOMOS?</h5>
        <h2>Refractarios y Aislamientos</h2>
      <p>Somos una empresa mexicana con más de 10 años de experiencia, especializada en brindar soluciones en la industria térmica. 
      Contamos con servicios de diagnóstico, asesoría y propuesta de materiales para reducir fugas de calor y 
      evitar afectaciones en sus operaciones. </p>
      </div>
      <div class="container3">
        <img src="IMAGEN/fireplace.jpg" alt="Imagen ajustada a la pantalla">
      </div>
    </div>
    <div class="container">
      <img src="IMAGEN/proposito1.png" alt="Imagen ajustada a la pantalla">
      </div>
      <div class="container1">
        <div class="texto">
          <h4>Misión</h4>
        <p>Fortalecer a nuestros clientes mediante la fabricación, distribución, instalación y asesoría en la generación 
          de ahorros de energía; ofreciendo una atención personalizada, tiempos de entrega, mejora de procesos, 
          siempre con inventarios especializados y trabajando día a día para lograr la satisfacción del cliente.</p>
          <h4>Visión</h4>
        <p>Ser referente global en Aislamientos y Refractarios de altas temperaturas, desarrollando soluciones 
          innovadoras, personalizadas que generen mayores beneficios para la industria con personal capacitado y comprometido</p>
        </div>
      </div>
        <div class="container2">
          <div class="cuadros">
              <div class="fila">
                  <div class="cuadro">
                      <h3>Eficacia</h3>
                      <p>Nos esforzamos por ser los más rápidos en atender y resolver las necesidades de los clientes.</p>
                  </div>
                  <div class="cuadro">
                      <h3>Comprimiso</h3>
                      <p>Nos coordinamos para entregar su producto al cliente en el tiempo en que lo prometemos y eso es un compromiso en todas las áreas.</p>
                  </div>
              </div>
              <div class="fila">
                  <div class="cuadro">
                      <h3>Honestidad</h3>
                      <p>Siempre decimos la verdad, al cliente, a los compañeros y a los superiores.</p>
                  </div>
                  <div class="cuadro">
                      <h3>Solución</h3>
                      <p>Entendemos la problemática de cliente y le hacemos propuestas de solución.</p>
                  </div>
              </div>
          </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</main>
  </body>
</html>