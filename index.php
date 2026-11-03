<?php
session_start();
require_once __DIR__ . '/db.php';

// Obtener mensajes de estado si existen
$statusMessage = $_SESSION['status_message'] ?? null;
$statusType    = $_SESSION['status_type'] ?? 'info';
unset($_SESSION['status_message'], $_SESSION['status_type']);

// Consultar todas las imágenes subidas
$consulta = "SELECT id, nombre, tipo, descripcion, creado_en FROM imagenes ORDER BY id DESC";
$datos = $db->query($consulta);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Subir imágenes a MySQL con PHP">
    <title>Subir y Ver Imágenes en MySQL</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- SB Admin 2 / Bootstrap CSS -->
    <link href="sb-admin-2.min.css" rel="stylesheet">

    <style>
        .gallery-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .gallery-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
        .gallery-img-container {
            width: 100%;
            height: 220px;
            background-color: #f8f9fc;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-bottom: 1px solid #e3e6f0;
        }
        .gallery-img-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body id="page-top" class="bg-gradient-light">

<div id="wrapper">
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content" class="py-5">
            <div class="container">

                <!-- Header de la aplicación -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
                        Gestor de Imágenes con PHP y MySQL
                    </h1>
                </div>

                <!-- Mensajes de alerta flash -->
                <?php if ($statusMessage): ?>
                    <div class="alert alert-<?= htmlspecialchars($statusType, ENT_QUOTES, 'UTF-8'); ?> alert-dismissible fade show shadow-sm" role="alert">
                        <strong><?= htmlspecialchars($statusMessage, ENT_QUOTES, 'UTF-8'); ?></strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Formulario de subida de imágenes -->
                <div class="row mb-5">
                    <div class="col-lg-8 mx-auto">
                        <div class="card border-left-primary shadow py-2">
                            <div class="card-header bg-transparent border-0 pt-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    Subir nueva imagen
                                </h6>
                            </div>
                            <div class="card-body">
                                <form action="upload.php" method="post" enctype="multipart/form-data">
                                    <div class="form-group mb-3">
                                        <label for="image" class="font-weight-bold text-gray-700">Seleccionar archivo de imagen:</label>
                                        <div class="custom-file">
                                            <input type="file" name="image" id="image" class="custom-file-input" accept="image/jpeg,image/png,image/gif,image/webp" required>
                                            <label class="custom-file-label" for="image" id="file-label">Elegir archivo...</label>
                                        </div>
                                        <small class="form-text text-muted">Formatos permitidos: JPG, PNG, GIF, WEBP.</small>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="descripcion" class="font-weight-bold text-gray-700">Descripción (opcional):</label>
                                        <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Ej: Foto de vacaciones, logotipo del proyecto..." maxlength="255">
                                    </div>

                                    <div class="text-right">
                                        <button type="submit" name="submit" class="btn btn-primary btn-icon-split shadow-sm">
                                            <span class="text">Subir a MySQL</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Galería de imágenes subidas -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    Galería de imágenes guardadas
                                </h6>
                                <span class="badge badge-primary px-3 py-2">
                                    Total: <?= $datos ? $datos->num_rows : 0; ?>
                                </span>
                            </div>
                            <div class="card-body">
                                <?php if ($datos && $datos->num_rows > 0): ?>
                                    <div class="row">
                                        <?php while ($fila = $datos->fetch_assoc()): ?>
                                            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                                                <div class="card h-100 shadow-sm border-0 gallery-card">
                                                    <div class="gallery-img-container">
                                                        <a href="view_image.php?id=<?= (int)$fila['id']; ?>" target="_blank" title="Ver imagen completa">
                                                            <img src="view_image.php?id=<?= (int)$fila['id']; ?>" alt="<?= htmlspecialchars($fila['descripcion'] ?: $fila['nombre'] ?: 'Imagen #' . $fila['id'], ENT_QUOTES, 'UTF-8'); ?>" loading="lazy">
                                                        </a>
                                                    </div>
                                                    <div class="card-body d-flex flex-column p-3">
                                                        <h6 class="card-title font-weight-bold text-dark text-truncate mb-1" title="<?= htmlspecialchars($fila['nombre'] ?? 'Sin nombre', ENT_QUOTES, 'UTF-8'); ?>">
                                                            <?= htmlspecialchars($fila['nombre'] ?: ('Imagen #' . $fila['id']), ENT_QUOTES, 'UTF-8'); ?>
                                                        </h6>
                                                        <p class="card-text text-muted small flex-grow-1 mb-2">
                                                            <?= !empty($fila['descripcion']) ? htmlspecialchars($fila['descripcion'], ENT_QUOTES, 'UTF-8') : '<em>Sin descripción</em>'; ?>
                                                        </p>
                                                        <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                                            <small class="text-xs text-gray-500 font-weight-bold">ID: #<?= (int)$fila['id']; ?></small>
                                                            <a href="view_image.php?id=<?= (int)$fila['id']; ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                                                                Ver directa
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="text-center py-5">
                                        <div class="text-gray-400 mb-3" style="font-size: 3rem;">📷</div>
                                        <h5 class="text-gray-600 font-weight-bold">Aún no hay imágenes almacenadas</h5>
                                        <p class="text-gray-500 mb-0">Usa el formulario superior para subir tu primera imagen a la base de datos.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Scripts JS simples para actualizar el label del input file y cerrar alertas -->
<script>
    document.getElementById('image').addEventListener('change', function(e) {
        var fileName = e.target.files[0] ? e.target.files[0].name : 'Elegir archivo...';
        document.getElementById('file-label').textContent = fileName;
    });
</script>

</body>
</html>
