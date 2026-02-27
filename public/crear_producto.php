<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Producto.php';

$errores = [];
$nombre = $descripcion = $precio = $stock = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto = new Producto(
        $_POST['nombre'] ?? '',
        $_POST['descripcion'] ?? '',
        $_POST['precio'] ?? '',
        $_POST['stock'] ?? ''
    );

    if ($producto->validar()) {
        $producto->guardar($pdo);
        header('Location: productos.php');
        exit();
    } else {
        $errores = $producto->errores;
        // mantenemos los valores en el formulario
        $nombre = $producto->nombre;
        $descripcion = $producto->descripcion;
        $precio = $producto->precio;
        $stock = $producto->stock;
    } //fin if validar

} //fin if POST
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Nuevo Producto</h4>
        </div>
        <div class="card-body">

            <?php if (!empty($errores)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errores as $e): ?>
                        <li><?php echo htmlspecialchars($e); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($nombre); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control"><?php echo htmlspecialchars($descripcion); ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Precio</label>
                    <input type="number" step="0.01" name="precio" class="form-control" value="<?php echo htmlspecialchars($precio); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock" class="form-control" value="<?php echo htmlspecialchars($stock); ?>">
                </div>
                <button type="submit" class="btn btn-success w-100">Guardar Producto</button>
                <a href="productos.php" class="btn btn-secondary w-100 mt-2">Cancelar</a>
            </form>

        </div>
    </div>
</div>
</body>
</html>