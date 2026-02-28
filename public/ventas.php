<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Venta.php';
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../services/VentaService.php';

$ventas = Venta::obtenerTodas($pdo);
$productos = Producto::obtenerTodos($pdo);
$mensaje = null;
$tipo = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto_id = $_POST['producto_id'] ?? '';
    $cantidad = $_POST['cantidad'] ?? '';

    $service = new VentaService();
    $resultado = $service->registrarVenta($pdo, $producto_id, $cantidad);

    if ($resultado['ok']) {
        // recargo las ventas despues de registrar
        $ventas = Venta::obtenerTodas($pdo);
        $mensaje = $resultado['mensaje'];
        $tipo = 'success';
    } else {
        $mensaje = $resultado['mensaje'];
        $tipo = 'danger';
    } 

} 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">

    <!-- formulario para registrar venta -->
    <div class="card shadow mb-4">
        <div class="card-header text-white" style="background-color: #0a5ca5;">
            <h4 class="mb-0">Registrar Venta</h4>
        </div>
        <div class="card-body">

            <?php if ($mensaje): ?>
            <div class="alert alert-<?php echo $tipo; ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Producto</label>
                    <select name="producto_id" class="form-select">
                        <option value="">-- Seleccione un producto --</option>
                        <?php foreach ($productos as $p): ?>
                        <option value="<?php echo $p['id']; ?>">
                            <?php echo htmlspecialchars($p['nombre']); ?> 
                            (Stock: <?php echo $p['stock']; ?> | 
                            Precio: $<?php echo number_format($p['precio'], 2); ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Cantidad</label>
                    <input type="number" name="cantidad" class="form-control" min="1">
                </div>
                <button type="submit" class="btn w-100 text-white" style="background-color: #0a5ca5;">
                    Registrar Venta
                </button>
                <a href="productos.php" class="btn btn-secondary w-100 mt-2">Ver Productos</a>
            </form>

        </div>
    </div>

    <!-- listado de ventas -->
    <div class="card shadow">
        <div class="card-header text-white" style="background-color: #687f94;">
            <h4 class="mb-0">Historial de Ventas</h4>
        </div>
        <div class="card-body">
            <?php if (empty($ventas)): ?>
                <p class="text-muted">No hay ventas registradas.</p>
            <?php else: ?>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ventas as $v): ?>
                    <tr>
                        <td><?php echo $v['id']; ?></td>
                        <td><?php echo htmlspecialchars($v['producto_nombre']); ?></td>
                        <td><?php echo $v['cantidad']; ?></td>
                        <td>$<?php echo number_format($v['precio_unitario'], 2); ?></td>
                        <td>$<?php echo number_format($v['total'], 2); ?></td>
                        <td><?php echo $v['fecha']; ?></td>
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