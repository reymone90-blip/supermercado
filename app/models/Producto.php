<?php
class Producto
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        return $this->pdo->query("
            SELECT p.*, c.nombre AS categoria
            FROM productos p
            LEFT JOIN categorias c ON p.categoria_id = c.id
            ORDER BY p.nombre
        ")->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM productos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function activos()
    {
        return $this->pdo->query("
            SELECT id, sku, nombre, precio_venta, costo, stock_actual
            FROM productos WHERE activo = 1 ORDER BY nombre
        ")->fetchAll();
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO productos (sku, nombre, categoria_id, costo, precio_venta, stock_actual, stock_minimo)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['sku'], $data['nombre'], $data['categoria_id'] ?: null,
            $data['costo'], $data['precio_venta'], $data['stock_actual'], $data['stock_minimo'],
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE productos
            SET sku=?, nombre=?, categoria_id=?, costo=?, precio_venta=?, stock_actual=?, stock_minimo=?
            WHERE id=?
        ");
        $stmt->execute([
            $data['sku'], $data['nombre'], $data['categoria_id'] ?: null,
            $data['costo'], $data['precio_venta'], $data['stock_actual'], $data['stock_minimo'], $id,
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function stockBajo()
    {
        return $this->pdo->query("
            SELECT p.*, c.nombre AS categoria
            FROM productos p
            LEFT JOIN categorias c ON p.categoria_id = c.id
            WHERE p.stock_actual <= p.stock_minimo AND p.activo = 1
            ORDER BY p.stock_actual ASC
        ")->fetchAll();
    }
}
