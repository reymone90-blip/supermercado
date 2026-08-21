<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Categoria.php';

function productos_listar($pdo)
{
    $productoModel = new Producto($pdo);
    $productos = $productoModel->all();
    require __DIR__ . '/../../views/layout/header.php';
    require __DIR__ . '/../../views/productos/listar.php';
    require __DIR__ . '/../../views/layout/footer.php';
}

function productos_agregar($pdo)
{
    $productoModel = new Producto($pdo);
    $categoriaModel = new Categoria($pdo);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productoModel->create($_POST);
        redireccionar('productos.listar');
    }

    $categorias = $categoriaModel->all();
    require __DIR__ . '/../../views/layout/header.php';
    require __DIR__ . '/../../views/productos/agregar.php';
    require __DIR__ . '/../../views/layout/footer.php';
}

function productos_editar($pdo)
{
    $productoModel = new Producto($pdo);
    $categoriaModel = new Categoria($pdo);

    $id = $_GET['id'] ?? null;
    if (!$id) redireccionar('productos.listar');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productoModel->update($id, $_POST);
        redireccionar('productos.listar');
    }

    $producto = $productoModel->find($id);
    if (!$producto) redireccionar('productos.listar');

    $categorias = $categoriaModel->all();
    require __DIR__ . '/../../views/layout/header.php';
    require __DIR__ . '/../../views/productos/editar.php';
    require __DIR__ . '/../../views/layout/footer.php';
}

function productos_eliminar($pdo)
{
    $productoModel = new Producto($pdo);
    $id = $_GET['id'] ?? null;
    if ($id) $productoModel->delete($id);
    redireccionar('productos.listar');
}
