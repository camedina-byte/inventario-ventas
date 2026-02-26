<?php
// Clase que representa un producto del inventario
class Producto
{
    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $stock;
    public $errores = [];

    public function __construct($nombre, $descripcion, $precio, $stock)
    {
        $this->nombre = trim($nombre);
        $this->descripcion = trim($descripcion);
        $this->precio = trim($precio);
        $this->stock = trim($stock);
    } //fin constructor

    // validaciones basicas del producto
    public function validar()
    {
        if ($this->nombre === '' || strlen($this->nombre) < 3) {
            $this->errores[] = "El nombre es obligatorio y debe tener al menos 3 caracteres";
        } //fin if nombre

        if (!is_numeric($this->precio) || $this->precio <= 0) {
            $this->errores[] = "El precio debe ser un número mayor a 0";
        } //fin if precio

        if (!ctype_digit($this->stock) || (int)$this->stock < 0) {
            $this->errores[] = "El stock debe ser un número entero mayor o igual a 0";
        } //fin if stock

        return empty($this->errores);
    } //fin validar

    // trae todos los productos de la base de datos
    public static function obtenerTodos($pdo)
    {
        $sql = "SELECT * FROM productos ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } //fin obtenerTodos

    // busca un producto por su id
    public static function obtenerPorId($pdo, $id)
    {
        $sql = "SELECT * FROM productos WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } //fin obtenerPorId

    // guarda el producto en la base de datos
    public function guardar($pdo)
    {
        $sql = "INSERT INTO productos (nombre, descripcion, precio, stock) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->nombre, $this->descripcion, $this->precio, $this->stock]);
    } //fin guardar

    // actualiza los datos del producto
    public function actualizar($pdo, $id)
    {
        $sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->nombre, $this->descripcion, $this->precio, $this->stock, $id]);
    } //fin actualizar

    // elimina un producto por id
    public static function eliminar($pdo, $id)
    {
        $sql = "DELETE FROM productos WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id]);
    } //fin eliminar

} //fin clase Producto
?>