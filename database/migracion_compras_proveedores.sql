-- =========================================
-- Migración: agrega Proveedores y Compras
-- Ejecutar esto si ya tenías la base de datos creada
-- =========================================
USE supermercado;

CREATE TABLE IF NOT EXISTS proveedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    contacto VARCHAR(100),
    telefono VARCHAR(30),
    direccion VARCHAR(200),
    activo TINYINT(1) DEFAULT 1,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    proveedor_id INT,
    usuario_id INT,
    total DECIMAL(10,2) NOT NULL DEFAULT 0,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (proveedor_id) REFERENCES proveedores(id) ON DELETE SET NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS detalle_compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    compra_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    costo_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (compra_id) REFERENCES compras(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);

ALTER TABLE productos
    ADD COLUMN proveedor_id INT NULL AFTER categoria_id,
    ADD FOREIGN KEY (proveedor_id) REFERENCES proveedores(id) ON DELETE SET NULL;

INSERT INTO proveedores (nombre, contacto, telefono, direccion) VALUES
('Distribuidora del Cibao', 'Juan Pérez', '809-555-0101', 'Santiago, RD'),
('Suplidora La Nacional', 'María Gómez', '809-555-0202', 'Santo Domingo, RD');
