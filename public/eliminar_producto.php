<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Producto.php';

// verificamos que venga un id valido
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: productos.php');
    exit();
} //fin if id

// verificamos que el producto exista antes de eliminar
$datos = Producto::obtenerPorId($pdo, $id);

if (!$datos) {
    header('Location: productos.php');
    exit();
} //fin if datos

Producto::eliminar($pdo, $id);
header('Location: productos.php');
exit();
?>