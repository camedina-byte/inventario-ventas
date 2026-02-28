<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Venta.php';
require_once __DIR__ . '/../models/Producto.php';

// servicio
class VentaService
{
    // registra la venta y descuenta el stock del producto
    public function registrarVenta($pdo, $producto_id, $cantidad)
    {
        // primero verificamos que el producto exista
        $producto = Producto::obtenerPorId($pdo, $producto_id);

        if (!$producto) {
            return ["ok" => false, "mensaje" => "El producto no existe"];
        } //fin if producto

        // verificamos que haya suficiente stock
        if ($producto['stock'] < $cantidad) {
            return ["ok" => false, "mensaje" => "Stock insuficiente. Stock disponible: " . $producto['stock']];
        } //fin if stock

        // creamos la venta con el precio actual del producto
        $venta = new Venta($producto_id, $cantidad, $producto['precio']);

        if (!$venta->validar()) {
            return ["ok" => false, "mensaje" => $venta->errores[0]];
        } //fin if validar

        // guarda la venta
        $venta->guardar($pdo);

        // descontamos el stock del producto
        $nuevoStock = $producto['stock'] - $cantidad;
        $sql = "UPDATE productos SET stock = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nuevoStock, $producto_id]);

        return ["ok" => true, "mensaje" => "Venta registrada correctamente"];

    } //fin registrarVenta

} //fin clase VentaService
?>