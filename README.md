# Subir y Almacenar Imágenes en MySQL con PHP

Pequeña aplicación en PHP para subir imágenes y guardarlas directamente en una base de datos MySQL (MariaDB) en un campo binario (`LONGBLOB`), permitiendo luego recuperarlas y mostrarlas en una galería interactiva.

## Características

- **Formulario de carga sencillo y limpio**: Permite seleccionar archivos de imagen (`.jpg`, `.jpeg`, `.png`, `.gif`, `.webp`) y añadir una descripción opcional.
- **Validación robusta**:
  - Valida que el archivo se haya recibido sin errores.
  - Comprueba que sea una imagen real utilizando `getimagesize()` y valida el tipo MIME.
  - Rechaza archivos que no sean imágenes o formatos no soportados.
- **Almacenamiento seguro**:
  - Conexión modular en `db.php` mediante MySQLi con soporte para variables de entorno (`DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`, `DB_PORT`).
  - Inserción mediante consultas preparadas (`prepared statements`) y envío seguro de datos binarios grandes (`send_long_data`).
- **Servicio y visualización de imágenes**:
  - Endpoint `view_image.php?id=X` que envía el contenido binario con los encabezados HTTP apropiados (`Content-Type`, `Content-Length`, `Cache-Control`).
- **Galería visual**:
  - Cuadrícula responsiva reutilizando los estilos de SB Admin 2 (`sb-admin-2.min.css`).
  - Muestra miniaturas, nombre del archivo, descripción, ID y enlace directo a cada imagen.

## Estructura de archivos

- `db.php`: Conexión centralizada a MySQL con variables de entorno por defecto.
- `index.php`: Página principal con formulario de subida, alertas flash de retroalimentación y galería de imágenes.
- `upload.php`: Lógica de validación del archivo subido e inserción en la base de datos.
- `view_image.php`: Endpoint para servir la imagen binaria desde la base de datos por ID.
- `script_sql`: Esquema SQL de la tabla `imagenes` y base de datos.
- `sb-admin-2.min.css`: Estilos basados en Bootstrap y SB Admin 2.

## Configuración y ejecución

1. Importar la estructura de la base de datos:
   ```bash
   mysql -u root -p < script_sql
   ```
2. (Opcional) Configurar credenciales mediante variables de entorno si difieren de las por defecto (`127.0.0.1`, `root`, sin contraseña, base de datos `upload_image`):
   ```bash
   export DB_HOST="127.0.0.1"
   export DB_USER="root"
   export DB_PASS=""
   export DB_NAME="upload_image"
   export DB_PORT=3306
   ```
3. Iniciar el servidor local de PHP:
   ```bash
   php -S 127.0.0.1:8000
   ```
4. Abrir en el navegador: `http://localhost:8000/index.php`.
