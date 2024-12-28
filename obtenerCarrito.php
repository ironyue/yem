<?php
header('Content-Type: application/json');
include 'config.php';

// Consultar los productos en el carrito
$sql = "SELECT carrito.id AS cid, productos.id AS pid, productos.nombre, productos.precio, carrito.cantidad FROM carrito JOIN productos ON carrito.producto_id = productos.id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $carrito = [];
    while($row = $result->fetch_assoc()) {
        $carrito[] = [
            'cid' => $row['cid'],
            'pid' => $row['pid'],
            'nombre' => $row['nombre'],
            'precio' => $row['precio'],
            'cantidad' => $row['cantidad']
        ];
    }
    echo json_encode(['success' => true, 'carrito' => $carrito]);
} else {
    echo json_encode(['success' => false, 'message' => 'El carrito está vacío']);
}

$conn->close();
?>
