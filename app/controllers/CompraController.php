<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Proveedor.php';
require_once __DIR__ . '/../models/Compra.php';

function compras_nueva($pdo)
{
    $productoModel = new Producto($pdo);
    $proveedorModel = new Proveedor($pdo);
    $productos = $productoModel->activos();
    $proveedores = $proveedorModel->activos();

    require __DIR__ . '/../../views/layout/header.php';
    require __DIR__ . '/../../views/compras/nueva.php';
    require __DIR__ . '/../../views/layout/footer.php';
}

function compras_procesar($pdo)
{
    $compraModel = new Compra($pdo);
    $carrito = json_decode($_POST['carrito'] ?? '{}', true);
    $proveedor_id = $_POST['proveedor_id'] ?? null;

    if (empty($carrito)) {
        redireccionar('compras.nueva');
    }

    try {
        $compra_id = $compraModel->procesar($carrito, $proveedor_id, usuarioActual()['id']);
        redireccionar('compras.detalle&id=' . $compra_id);
    } catch (Exception $e) {
        die('Error al procesar la compra: ' . $e->getMessage());
    }
}

function compras_listar($pdo)
{
    $compraModel = new Compra($pdo);
    $compras = $compraModel->all();
    require __DIR__ . '/../../views/layout/header.php';
    require __DIR__ . '/../../views/compras/listar.php';
    require __DIR__ . '/../../views/layout/footer.php';
}

function compras_detalle($pdo)
{
    $compraModel = new Compra($pdo);
    $id = $_GET['id'] ?? null;
    if (!$id) redireccionar('compras.listar');

    $compra = $compraModel->find($id);
    $detalle = $compraModel->detalle($id);

    require __DIR__ . '/../../views/layout/header.php';
    require __DIR__ . '/../../views/compras/detalle.php';
    require __DIR__ . '/../../views/layout/footer.php';
}
