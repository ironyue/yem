<?php
header('Content-Type: application/json');
include 'config.php';

// Obtener el ID del producto a eliminar del carrito
$data = json_decode(file_get_contents('php://input'), true);
$carrito_id = $data['id'];

// Eliminar el producto del carrito
$stmt = $conn->prepare("DELETE FROM carrito WHERE id = ?");
$stmt->bind_param("i", $carrito_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al eliminar producto del carrito']);
}

$stmt->close();
$conn->close();
?>
