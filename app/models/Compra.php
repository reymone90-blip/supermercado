<?php
class Compra
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function procesar($carrito, $proveedor_id, $usuario_id)
    {
        $this->pdo->beginTransaction();
        try {
            $total = 0;
            foreach ($carrito as $item) {
                $total += $item['cantidad'] * $item['costo'];
            }

            $stmtCompra = $this->pdo->prepare("
                INSERT INTO compras (proveedor_id, usuario_id, total)
                VALUES (?, ?, ?)
            ");
            $stmtCompra->execute([$proveedor_id ?: null, $usuario_id, $total]);
            $compra_id = $this->pdo->lastInsertId();

            $stmtDetalle = $this->pdo->prepare("
                INSERT INTO detalle_compras (compra_id, producto_id, cantidad, costo_unitario, subtotal)
                VALUES (?, ?, ?, ?, ?)
            ");
            // Suma stock y actualiza el costo del producto con el costo más reciente de compra
            $stmtStock = $this->pdo->prepare("
                UPDATE productos SET stock_actual = stock_actual + ?, costo = ? WHERE id = ?
            ");

            foreach ($carrito as $producto_id => $item) {
                $subtotal = $item['cantidad'] * $item['costo'];
                $stmtDetalle->execute([$compra_id, $producto_id, $item['cantidad'], $item['costo'], $subtotal]);
                $stmtStock->execute([$item['cantidad'], $item['costo'], $producto_id]);
            }

            $this->pdo->commit();
            return $compra_id;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function all()
    {
        return $this->pdo->query("
            SELECT c.*, p.nombre AS proveedor, u.nombre AS usuario
            FROM compras c
            LEFT JOIN proveedores p ON c.proveedor_id = p.id
            LEFT JOIN usuarios u ON c.usuario_id = u.id
            ORDER BY c.fecha DESC
        ")->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("
            SELECT c.*, p.nombre AS proveedor
            FROM compras c
            LEFT JOIN proveedores p ON c.proveedor_id = p.id
            WHERE c.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function detalle($compra_id)
    {
        $stmt = $this->pdo->prepare("
            SELECT dc.*, pr.nombre, pr.sku
            FROM detalle_compras dc
            JOIN productos pr ON dc.producto_id = pr.id
            WHERE dc.compra_id = ?
        ");
        $stmt->execute([$compra_id]);
        return $stmt->fetchAll();
    }
}
