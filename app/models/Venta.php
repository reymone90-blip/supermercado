<?php
class Venta
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function procesar($carrito, $metodo_pago, $usuario_id = 1)
    {
        $this->pdo->beginTransaction();
        try {
            $total = 0;
            $gananciaTotal = 0;
            foreach ($carrito as $item) {
                $total += $item['cantidad'] * $item['precio'];
                $gananciaTotal += $item['cantidad'] * ($item['precio'] - $item['costo']);
            }

            $stmtVenta = $this->pdo->prepare("
                INSERT INTO ventas (usuario_id, total, ganancia, metodo_pago)
                VALUES (?, ?, ?, ?)
            ");
            $stmtVenta->execute([$usuario_id, $total, $gananciaTotal, $metodo_pago]);
            $venta_id = $this->pdo->lastInsertId();

            $stmtDetalle = $this->pdo->prepare("
                INSERT INTO detalle_ventas (venta_id, producto_id, cantidad, precio_unitario, costo_unitario, subtotal)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmtStock = $this->pdo->prepare("
                UPDATE productos SET stock_actual = stock_actual - ? WHERE id = ? AND stock_actual >= ?
            ");

            foreach ($carrito as $producto_id => $item) {
                $subtotal = $item['cantidad'] * $item['precio'];
                $stmtDetalle->execute([
                    $venta_id, $producto_id, $item['cantidad'], $item['precio'], $item['costo'], $subtotal
                ]);

                $stmtStock->execute([$item['cantidad'], $producto_id, $item['cantidad']]);
                if ($stmtStock->rowCount() === 0) {
                    throw new Exception("Stock insuficiente para el producto ID $producto_id");
                }
            }

            $this->pdo->commit();
            return $venta_id;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM ventas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function detalle($venta_id)
    {
        $stmt = $this->pdo->prepare("
            SELECT dv.*, p.nombre, p.sku
            FROM detalle_ventas dv
            JOIN productos p ON dv.producto_id = p.id
            WHERE dv.venta_id = ?
        ");
        $stmt->execute([$venta_id]);
        return $stmt->fetchAll();
    }

    public function resumenHoy()
    {
        $stmt = $this->pdo->query("
            SELECT COUNT(*) cantidad, COALESCE(SUM(total),0) total, COALESCE(SUM(ganancia),0) ganancia
            FROM ventas WHERE DATE(fecha) = CURDATE()
        ");
        return $stmt->fetch();
    }

    public function resumenPeriodo($desde, $hasta)
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) cantidad, COALESCE(SUM(total),0) total, COALESCE(SUM(ganancia),0) ganancia
            FROM ventas WHERE DATE(fecha) BETWEEN ? AND ?
        ");
        $stmt->execute([$desde, $hasta]);
        return $stmt->fetch();
    }

    public function ventasPorDia($desde, $hasta)
    {
        $stmt = $this->pdo->prepare("
            SELECT DATE(fecha) dia, COALESCE(SUM(total),0) total, COALESCE(SUM(ganancia),0) ganancia
            FROM ventas
            WHERE DATE(fecha) BETWEEN ? AND ?
            GROUP BY DATE(fecha)
            ORDER BY dia
        ");
        $stmt->execute([$desde, $hasta]);
        return $stmt->fetchAll();
    }

    public function productosMasVendidos($desde, $hasta, $limite = 10)
    {
        $stmt = $this->pdo->prepare("
            SELECT p.nombre, p.sku,
                   SUM(dv.cantidad) unidades,
                   SUM(dv.subtotal) total_vendido,
                   SUM(dv.cantidad * (dv.precio_unitario - dv.costo_unitario)) ganancia
            FROM detalle_ventas dv
            JOIN productos p ON dv.producto_id = p.id
            JOIN ventas v ON dv.venta_id = v.id
            WHERE DATE(v.fecha) BETWEEN ? AND ?
            GROUP BY dv.producto_id, p.nombre, p.sku
            ORDER BY unidades DESC
            LIMIT $limite
        ");
        $stmt->execute([$desde, $hasta]);
        return $stmt->fetchAll();
    }

    public function gananciaPorCategoria($desde, $hasta)
    {
        $stmt = $this->pdo->prepare("
            SELECT COALESCE(c.nombre, 'Sin categoría') categoria,
                   SUM(dv.subtotal) total_vendido,
                   SUM(dv.cantidad * (dv.precio_unitario - dv.costo_unitario)) ganancia
            FROM detalle_ventas dv
            JOIN productos p ON dv.producto_id = p.id
            LEFT JOIN categorias c ON p.categoria_id = c.id
            JOIN ventas v ON dv.venta_id = v.id
            WHERE DATE(v.fecha) BETWEEN ? AND ?
            GROUP BY c.id, categoria
            ORDER BY ganancia DESC
        ");
        $stmt->execute([$desde, $hasta]);
        return $stmt->fetchAll();
    }
}
