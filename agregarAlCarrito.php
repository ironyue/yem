<?php
header('Content-Type: application/json');
include 'config.php';

// Obtener el ID del producto a añadir al carrito
$data = json_decode(file_get_contents('php://input'), true);
$producto_id = $data['id'];

// Insertar el producto en la tabla 'carrito'
$stmt = $conn->prepare("INSERT INTO carrito (producto_id, cantidad) VALUES (?, 1)");
$stmt->bind_param("i", $producto_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al agregar producto al carrito']);
}

$stmt->close();
$conn->close();
?>
