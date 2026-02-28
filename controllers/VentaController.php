<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Venta.php';
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../services/VentaService.php';

class VentaController
{
    // muestra el listado de ventas y el formulario
    public function index()
    {
        $ventas = Venta::obtenerTodas($pdo);
        $productos = Producto::obtenerTodos($pdo);
        require_once __DIR__ . '/../public/ventas.php';
    }

    // registra una nueva venta
    public function registrar()
    {
        $mensaje = null;
        $tipo = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $producto_id = $_POST['producto_id'] ?? '';
            $cantidad = $_POST['cantidad'] ?? '';

            $service = new VentaService();
            $resultado = $service->registrarVenta($pdo, $producto_id, $cantidad);

            if ($resultado['ok']) {
                header('Location: ../public/ventas.php');
                exit();
            } else {
                $mensaje = $resultado['mensaje'];
                $tipo = 'danger';
            } 

        } 

        $ventas = Venta::obtenerTodas($pdo);
        $productos = Producto::obtenerTodos($pdo);
        require_once __DIR__ . '/../public/ventas.php';
    } 

} 
?>