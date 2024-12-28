<?php
header('Content-Type: application/json');

// Aquí deberás incluir tus credenciales de API de Correo Argentino
$api_url = 'https://api.correoargentino.com.ar/shipments/getRate';
$api_key = 'https://apitest.correoargentino.com.ar/micorreo/v1';

// Obtener el código postal desde la solicitud
$codigo_postal = $_GET['codigo_postal'];

// Configura los parámetros para la solicitud a la API
$params = [
    'origin_postal_code' => '1657',
    'destination_postal_code' => $codigo_postal,
    'weight' => 1.0, // Peso del paquete en kg
    'dimensions' => [20, 20, 20] // Dimensiones del paquete (largo, ancho, alto) en cm
];

// Realiza la solicitud a la API de Correo Argentino
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key
]);
$response = curl_exec($ch);
curl_close($ch);

// Decodifica la respuesta y extrae el costo de envío
$response_data = json_decode($response, true);
if ($response_data && isset($response_data['rate'])) {
    $costo_envio = $response_data['rate'];
    echo json_encode(['success' => true, 'costoEnvio' => $costo_envio]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al obtener el costo de envío']);
}
?>
