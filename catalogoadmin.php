<?php include 'conexion.php'; ?>

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
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
       

        .producto {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .producto h3 {
            margin-top: 0;
            color: #007bff;
        }

        .producto img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .producto p {
            margin: 5px 0;
        }

        .buscador {
            margin-bottom: 20px;
        }

        .btn {
            border-radius: 5px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .btn-secondary {
            background-color: #6c757d;
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
                <li><a href="nosotrosadmin.php">Acerca de nosotros</a></li>
                <li><a href="#contacto">Contáctanos</a></li>
                <li><a href="catalogoadmin.php">Catálogo</a></li>
                <li><a href="menuadmin.php">Menu</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="buscador">
            <form method="GET">
                <input type="text" name="nombre" placeholder="Buscar por nombre" value="<?php echo isset($_GET['nombre']) ? $_GET['nombre'] : ''; ?>">
                <input type="number" name="precio_min" placeholder="Precio mínimo" value="<?php echo isset($_GET['precio_min']) ? $_GET['precio_min'] : ''; ?>">
                <input type="number" name="precio_max" placeholder="Precio máximo" value="<?php echo isset($_GET['precio_max']) ? $_GET['precio_max'] : ''; ?>">
                <select name="categoria">
                    <option value="">Seleccionar categoría</option>
                    <?php
                    // Consulta para obtener las categorías disponibles
                    $sql = "SELECT DescripcionCategoria FROM categoria";
                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='".$row["DescripcionCategoria"]."' ".(isset($_GET['categoria']) && $_GET['categoria'] == $row["DescripcionCategoria"] ? 'selected' : '').">".$row["DescripcionCategoria"]."</option>";
                    }
                    ?>
                </select>
                <button type="submit" class="btn">Buscar</button>
                <a href="catalogo.php" class="btn btn-secondary">Cancelar búsquedas</a>
            </form>
        </div>
        <?php
        // Construir la consulta SQL
        $sql = "SELECT p.IDProducto, p.NombreProducto, p.ImagenProducto, p.PrecioProducto, c.DescripcionCategoria 
                FROM producto p 
                INNER JOIN categoria c ON p.IDCategoria = c.IDCategoria";
        
        // Agregar condiciones según los parámetros de búsqueda ingresados
        if(isset($_GET['nombre']) && !empty($_GET['nombre'])) {
            $nombre = $_GET['nombre'];
            $sql .= " WHERE p.NombreProducto LIKE '%$nombre%'";
        }
        if(isset($_GET['precio_min']) && !empty($_GET['precio_min'])) {
            $precio_min = $_GET['precio_min'];
            $sql .= " AND p.PrecioProducto >= $precio_min";
        }
        if(isset($_GET['precio_max']) && !empty($_GET['precio_max'])) {
            $precio_max = $_GET['precio_max'];
            $sql .= " AND p.PrecioProducto <= $precio_max";
        }
        if(isset($_GET['categoria']) && !empty($_GET['categoria'])) {
            $categoria = $_GET['categoria'];
            $sql .= " AND c.DescripcionCategoria = '$categoria'";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='producto'>";
                echo "<h3>" . $row["NombreProducto"] . "</h3>";
                echo "<img src='data:image/jpeg;base64,".base64_encode($row['ImagenProducto'])."' alt='" . $row["NombreProducto"] . "'>";
                echo "<p>Precio: $" . $row["PrecioProducto"] . "</p>";
                echo "<p>Categoría: " . $row["DescripcionCategoria"] . "</p>";
                // Botón "Agregar a carrito" que redirige a login.php si no ha iniciado sesión
                echo "<form action='agregar_al_carrito.php' method='post'>";
                echo "<input type='hidden' name='producto_id' value='" . $row["IDProducto"] . "'>";
                echo "<button type='submit' class='btn' onclick='agregarACarrito(event)'>Agregar a carrito</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "0 resultados";
        }
        ?>
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
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function agregarACarrito(event) {
            // Evita el comportamiento predeterminado del formulario (enviarlo)
            event.preventDefault();
            // Muestra una alerta
            alert("Por favor, inicie sesión como cliente.");
        }
    </script>
</body>
</html>
