<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Producto.php';

class ProductoController
{
    // muestra la lista de productos
    public function listar()
    {
        $productos = Producto::obtenerTodos($pdo);
        require_once __DIR__ . '/../public/productos.php';
    } //fin listar

    // muestra el formulario para crear un producto
    public function crear()
    {
        $errores = [];
        $producto = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $producto = new Producto(
                $_POST['nombre'] ?? '',
                $_POST['descripcion'] ?? '',
                $_POST['precio'] ?? '',
                $_POST['stock'] ?? ''
            );

            if ($producto->validar()) {
                $producto->guardar($pdo);
                header('Location: ../public/productos.php');
                exit();
            } else {
                $errores = $producto->errores;
            } //fin if validar

        } //fin if POST

        require_once __DIR__ . '/../public/crear_producto.php';
    } //fin crear

    // carga los datos y guarda los cambios del producto
    public function editar($id)
    {
        $datos = Producto::obtenerPorId($pdo, $id);
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $producto = new Producto(
                $_POST['nombre'] ?? '',
                $_POST['descripcion'] ?? '',
                $_POST['precio'] ?? '',
                $_POST['stock'] ?? ''
            );

            if ($producto->validar()) {
                $producto->actualizar($pdo, $id);
                header('Location: ../public/productos.php');
                exit();
            } else {
                $errores = $producto->errores;
            } //fin if validar

        } //fin if POST

        require_once __DIR__ . '/../public/editar_producto.php';
    } //fin editar

    // elimina un producto por id
    public function eliminar($id)
    {
        Producto::eliminar($pdo, $id);
        header('Location: ../public/productos.php');
        exit();
    } //fin eliminar

} //fin clase ProductoController
?>