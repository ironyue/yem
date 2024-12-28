<?php
include 'config.php';

// Consultar los productos
$sql = "SELECT id, nombre, precio FROM productos";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Nuestros Productos</h1>
    </header>
    <div class="container">
        <section class="lista-productos">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='producto'>";
                    echo "<h3>" . $row['nombre'] . "</h3>";
                    echo "<p>Precio: $" . $row['precio'] . "</p>";
                    echo "<button class='add-to-cart' data-id='" . $row['id'] . "'>Agregar al Carrito</button>";
                    echo "</div>";
                }
            } else {
                echo "<p>No se encontraron productos</p>";
            }
            ?>
        </section>
    </div>
    <footer>
        <p>&copy; 2024 Tienda de Cosméticos y Holísticos</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>
<?php
$conn->close();
?>
