<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Producto.php';

$productos = Producto::obtenerTodos($pdo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Lista de Productos</h4>
        </div>
        <div class="card-body">
            <a href="crear_producto.php" class="btn btn-success mb-3">+ Nuevo Producto</a>
            <?php if (empty($productos)): ?>
                <p class="text-muted">No hay productos registrados.</p>
            <?php else: ?>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $p): ?>
                    <tr>
                        <td><?php echo $p['id']; ?></td>
                        <td><?php echo htmlspecialchars($p['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($p['descripcion']); ?></td>
                        <td>$<?php echo number_format($p['precio'], 2); ?></td>
                        <td><?php echo $p['stock']; ?></td>
                        <td>
                            <a href="editar_producto.php?id=<?php echo $p['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="eliminar_producto.php?id=<?php echo $p['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>