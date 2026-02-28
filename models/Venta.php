<?php
// Clase que representa una venta
class Venta
{
    public $producto_id;
    public $cantidad;
    public $precio_unitario;
    public $total;
    public $errores = [];

    public function __construct($producto_id, $cantidad, $precio_unitario)
    {
        $this->producto_id = trim($producto_id);
        $this->cantidad = trim($cantidad);
        $this->precio_unitario = trim($precio_unitario);
        $this->total = $this->cantidad * $this->precio_unitario;
    } //fin constructor

    // validaciones basicas 
    public function validar()
    {
        if (empty($this->producto_id)) {
            $this->errores[] = "Debe seleccionar un producto";
        } //fin if producto

        if (!ctype_digit($this->cantidad) || (int)$this->cantidad <= 0) {
            $this->errores[] = "La cantidad debe ser un número entero mayor a 0";
        } //fin if cantidad

        return empty($this->errores);
    } //fin validar

    // guarda la venta en la base de datos
    public function guardar($pdo)
    {
        $sql = "INSERT INTO ventas (producto_id, cantidad, precio_unitario, total) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->producto_id, $this->cantidad, $this->precio_unitario, $this->total]);
    } //fin guardar

    // trae todas las ventas con el nombre del producto
    public static function obtenerTodas($pdo)
    {
        $sql = "SELECT v.*, p.nombre as producto_nombre 
                FROM ventas v 
                JOIN productos p ON v.producto_id = p.id 
                ORDER BY v.id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } //fin obtenerTodas

} //fin clase Venta
?>