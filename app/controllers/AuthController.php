<?php
require_once __DIR__ . '/../models/Usuario.php';

function auth_login($pdo)
{
    // Si ya inició sesión, lo mandamos directo al panel
    if (estaLogueado()) {
        redireccionar('inicio');
    }

    $error = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuarioModel = new Usuario($pdo);
        $fila = $usuarioModel->verificar($_POST['usuario'] ?? '', $_POST['clave'] ?? '');

        if ($fila) {
            $_SESSION['usuario_id'] = $fila['id'];
            $_SESSION['usuario'] = [
                'id'      => $fila['id'],
                'nombre'  => $fila['nombre'],
                'usuario' => $fila['usuario'],
                'rol'     => $fila['rol'],
            ];
            redireccionar('inicio');
        } else {
            $error = 'Usuario o contraseña incorrectos.';
        }
    }

    require __DIR__ . '/../../views/usuarios/login.php';
}

function auth_logout()
{
    session_unset();
    session_destroy();
    redireccionar('login');
}
