<?php
// Configuración de la base de datos
$dbHost     = getenv('DB_HOST') ?: '127.0.0.1';
$dbUsername = getenv('DB_USER') ?: 'root';
$dbPassword = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
$dbName     = getenv('DB_NAME') ?: 'upload_image';
$dbPort     = getenv('DB_PORT') ? (int)getenv('DB_PORT') : 3306;

// Crear conexión MySQLi
$db = @new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbPort);

// Verificar conexión
if ($db->connect_error) {
    die("Error en la conexión a la base de datos: " . $db->connect_error);
}

// Establecer conjunto de caracteres UTF-8
$db->set_charset('utf8mb4');
