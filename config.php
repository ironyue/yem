<?php
$servername = "localhost";
$username = "id22336086_morandi";
$password = "Cabezaa68";
$dbname = "id22336086_crud";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}
?>
