<?php
require_once __DIR__ . '/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    http_response_code(400);
    echo "ID de imagen no válido.";
    exit;
}

$stmt = $db->prepare("SELECT tipo, imagen FROM imagenes WHERE id = ?");
if (!$stmt) {
    http_response_code(500);
    echo "Error en la consulta: " . $db->error;
    exit;
}

$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    http_response_code(404);
    echo "Imagen no encontrada.";
    $stmt->close();
    exit;
}

$tipo = '';
$imagen = null;
$stmt->bind_result($tipo, $imagen);
$stmt->fetch();
$stmt->close();

$mimeType = !empty($tipo) ? $tipo : 'image/jpeg';

header("Content-Type: " . $mimeType);
header("Content-Length: " . strlen($imagen));
header("Cache-Control: public, max-age=86400");

echo $imagen;
exit;
