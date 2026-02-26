-- Base de datos del sistema de inventario y ventas
CREATE DATABASE IF NOT EXISTS inventario_ventas;
USE inventario_ventas;

-- Tabla de productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Datos de prueba
INSERT INTO productos (nombre, descripcion, precio, stock) VALUES
('Cuaderno universitario', 'Cuaderno de 100 hojas', 2.50, 50),
('Esfero azul', 'Esfero punta fina', 0.75, 100),
('Calculadora', 'Calculadora cientifica basica', 15.00, 20);