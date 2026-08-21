<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Venta.php';

function ventas_pos($pdo)
{
    $productoModel = new Producto($pdo);
    $productos = $productoModel->activos();
    require __DIR__ . '/../../views/layout/header.php';
    require __DIR__ . '/../../views/ventas/pos.php';
    require __DIR__ . '/../../views/layout/footer.php';
}

function ventas_procesar($pdo)
{
    $ventaModel = new Venta($pdo);
    $carrito = json_decode($_POST['carrito'] ?? '{}', true);
    $metodo_pago = $_POST['metodo_pago'] ?? 'efectivo';

    if (empty($carrito)) {
        redireccionar('ventas.pos');
    }

    try {
        $venta_id = $ventaModel->procesar($carrito, $metodo_pago, usuarioActual()['id']);
        redireccionar('ventas.recibo&id=' . $venta_id);
    } catch (Exception $e) {
        die('Error al procesar la venta: ' . $e->getMessage());
    }
}

function ventas_recibo($pdo)
{
    $ventaModel = new Venta($pdo);
    $id = $_GET['id'] ?? null;
    if (!$id) redireccionar('ventas.pos');

    $venta = $ventaModel->find($id);
    $detalle = $ventaModel->detalle($id);

    require __DIR__ . '/../../views/layout/header.php';
    require __DIR__ . '/../../views/ventas/recibo.php';
    require __DIR__ . '/../../views/layout/footer.php';
}
