<?php
require_once __DIR__ . '/../models/Usuario.php';

function usuarios_listar($pdo)
{
    requiereAdmin();
    $usuarioModel = new Usuario($pdo);
    $usuarios = $usuarioModel->all();
    require __DIR__ . '/../../views/layout/header.php';
    require __DIR__ . '/../../views/usuarios/listar.php';
    require __DIR__ . '/../../views/layout/footer.php';
}

function usuarios_agregar($pdo)
{
    requiereAdmin();
    $usuarioModel = new Usuario($pdo);
    $error = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($usuarioModel->existeUsuario($_POST['usuario'])) {
            $error = 'Ese nombre de usuario ya está en uso.';
        } else {
            $usuarioModel->create($_POST);
            redireccionar('usuarios.listar');
        }
    }

    require __DIR__ . '/../../views/layout/header.php';
    require __DIR__ . '/../../views/usuarios/agregar.php';
    require __DIR__ . '/../../views/layout/footer.php';
}

function usuarios_editar($pdo)
{
    requiereAdmin();
    $usuarioModel = new Usuario($pdo);
    $id = $_GET['id'] ?? null;
    if (!$id) redireccionar('usuarios.listar');

    $error = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($usuarioModel->existeUsuario($_POST['usuario'], $id)) {
            $error = 'Ese nombre de usuario ya está en uso.';
        } else {
            $usuarioModel->update($id, $_POST);
            redireccionar('usuarios.listar');
        }
    }

    $usuario = $usuarioModel->find($id);
    if (!$usuario) redireccionar('usuarios.listar');

    require __DIR__ . '/../../views/layout/header.php';
    require __DIR__ . '/../../views/usuarios/editar.php';
    require __DIR__ . '/../../views/layout/footer.php';
}

function usuarios_toggle($pdo)
{
    requiereAdmin();
    $usuarioModel = new Usuario($pdo);
    $id = $_GET['id'] ?? null;

    // Evita que el admin se desactive a sí mismo por accidente
    if ($id && $id != usuarioActual()['id']) {
        $usuarioModel->toggleActivo($id);
    }
    redireccionar('usuarios.listar');
}
