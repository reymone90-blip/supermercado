<?php
require_once __DIR__ . '/../models/Proveedor.php';

function proveedores_listar($pdo)
{
    $proveedorModel = new Proveedor($pdo);
    $proveedores = $proveedorModel->all();
    require __DIR__ . '/../../views/layout/header.php';
    require __DIR__ . '/../../views/proveedores/listar.php';
    require __DIR__ . '/../../views/layout/footer.php';
}

function proveedores_agregar($pdo)
{
    $proveedorModel = new Proveedor($pdo);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $proveedorModel->create($_POST);
        redireccionar('proveedores.listar');
    }

    require __DIR__ . '/../../views/layout/header.php';
    require __DIR__ . '/../../views/proveedores/agregar.php';
    require __DIR__ . '/../../views/layout/footer.php';
}

function proveedores_editar($pdo)
{
    $proveedorModel = new Proveedor($pdo);
    $id = $_GET['id'] ?? null;
    if (!$id) redireccionar('proveedores.listar');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $proveedorModel->update($id, $_POST);
        redireccionar('proveedores.listar');
    }

    $proveedor = $proveedorModel->find($id);
    if (!$proveedor) redireccionar('proveedores.listar');

    require __DIR__ . '/../../views/layout/header.php';
    require __DIR__ . '/../../views/proveedores/editar.php';
    require __DIR__ . '/../../views/layout/footer.php';
}

function proveedores_eliminar($pdo)
{
    $proveedorModel = new Proveedor($pdo);
    $id = $_GET['id'] ?? null;
    if ($id) $proveedorModel->delete($id);
    redireccionar('proveedores.listar');
}
