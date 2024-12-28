<?php
include 'config.php';

// Consultar los productos en el carrito
$sql = "SELECT carrito.id AS cid, productos.id AS pid, productos.nombre, productos.precio, carrito.cantidad FROM carrito JOIN productos ON carrito.producto_id = productos.id";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Carrito de Compras</h1>
    </header>
    <div class="container">
        <section class="carrito">
            <h2>Carrito de Compras</h2>
            <div class="lista-carrito">
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='producto-carrito'>";
                        echo "<div class='detalles-producto'>";
                        echo "<h3>" . $row['nombre'] . "</h3>";
                        echo "<p>Precio: $" . $row['precio'] . "</p>";
                        echo "<p>Cantidad: " . $row['cantidad'] . "</p>";
                        echo "</div>";
                        echo "<button class='remove-from-cart' data-id='" . $row['cid'] . "'>Eliminar</button>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>El carrito está vacío</p>";
                }
                ?>
            </div>
            <div class="totales">
                <div>Subtotal: $<span id="subtotal">0.00</span></div>
                <div>Costo de Envío: $<span id="costo-envio">0.00</span></div>
                <div>Total: $<span id="total">0.00</span></div>
            </div>
            <button id="proceder-pago">Proceder al Pago</button>
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
