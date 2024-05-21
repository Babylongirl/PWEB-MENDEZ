<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Méndez-Refractarios y Aislamientos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="CSS/CSS.css">
    <style>
        /* Estilos adicionales para el menú de hamburguesa */
        .menu-hamburguesa {
            display: none;
            position: absolute;
            top: 10px;
            right: 20px;
            cursor: pointer;
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
            top: 60px;
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
          <a href="indexcliente.php">
            <img src="IMAGEN/logoEmpresa1.png" alt="Logo de la empresa">
          </a>
        </div>
        <nav>
            <ul>
                <li><a href="nosotroscliente.php">Acerca de nosotros</a></li>
                <li><a href="contactanoscliente.php">Contáctanos</a></li>
                <li><a href="catalogocliente.php">Catálogo</a></li>
                <li><a href="menucliente.php">Menu</a></li>
            </ul>
        </nav>
        <!-- Menú de hamburguesa -->
        <div class="menu-hamburguesa" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <!-- Contenido del menú desplegable -->
        <div class="menu-content" id="menuContent">
            <a href="nosotroscliente.php">Acerca de nosotros</a>
            <a href="contactanoscliente.php">Contáctanos</a>
            <a href="catalogocliente.php">Catálogo</a>
            <a href="menucliente.php">Menu</a>
        </div>
    </header>
    <main>
        <!-- Contenido principal de la página -->
    </main>
    <footer>
        <div class="gallery">
            <!-- Carrusel de Bootstrap -->
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-indicators">
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
              </div>
              <div class="carousel-inner">
                  <div class="carousel-item active">
                      <img src="IMAGEN/LALAA1.jpg" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                      <img src="IMAGEN/horno (2).png" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                      <img src="IMAGEN/lolo.jpg" class="d-block w-100" alt="...">
                  </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
              </button>
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
</body>
</html>
