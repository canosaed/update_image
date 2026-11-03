<?php
session_start();
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';

    // Validar si se seleccionó y envió un archivo
    if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
        $_SESSION['status_message'] = 'Por favor seleccione una imagen para cargar.';
        $_SESSION['status_type'] = 'warning';
        header('Location: index.php');
        exit;
    }

    $fileError = $_FILES['image']['error'];
    if ($fileError !== UPLOAD_ERR_OK) {
        $_SESSION['status_message'] = 'Error al subir el archivo (código ' . $fileError . ').';
        $_SESSION['status_type'] = 'danger';
        header('Location: index.php');
        exit;
    }

    $tmpPath = $_FILES['image']['tmp_name'];
    $originalName = basename($_FILES['image']['name']);

    // Validar con getimagesize si es realmente una imagen válida
    $imageInfo = @getimagesize($tmpPath);
    if ($imageInfo === false) {
        $_SESSION['status_message'] = 'El archivo seleccionado no es una imagen válida.';
        $_SESSION['status_type'] = 'danger';
        header('Location: index.php');
        exit;
    }

    $mimeType = $imageInfo['mime'];
    $allowedTypes = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp'
    ];

    if (!in_array($mimeType, $allowedTypes, true)) {
        $_SESSION['status_message'] = 'Formato no permitido. Solo se aceptan imágenes JPG, PNG, GIF o WEBP.';
        $_SESSION['status_type'] = 'danger';
        header('Location: index.php');
        exit;
    }

    // Leer contenido binario de la imagen
    $imgData = file_get_contents($tmpPath);
    if ($imgData === false) {
        $_SESSION['status_message'] = 'No se pudo leer el archivo cargado.';
        $_SESSION['status_type'] = 'danger';
        header('Location: index.php');
        exit;
    }

    // Insertar en la base de datos usando prepared statement
    $stmt = $db->prepare("INSERT INTO imagenes (nombre, tipo, descripcion, imagen) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        $_SESSION['status_message'] = 'Error al preparar la consulta: ' . $db->error;
        $_SESSION['status_type'] = 'danger';
        header('Location: index.php');
        exit;
    }

    // Usar 'b' para el blob
    $null = null;
    $stmt->bind_param('sssb', $originalName, $mimeType, $descripcion, $null);
    $stmt->send_long_data(3, $imgData);

    if ($stmt->execute()) {
        $_SESSION['status_message'] = '¡Imagen subida y guardada exitosamente en la base de datos!';
        $_SESSION['status_type'] = 'success';
    } else {
        $_SESSION['status_message'] = 'Error al guardar la imagen en la base de datos: ' . $stmt->error;
        $_SESSION['status_type'] = 'danger';
    }
    $stmt->close();

    header('Location: index.php');
    exit;
} else {
    // Si acceden por GET, redirigir a index
    header('Location: index.php');
    exit;
}
