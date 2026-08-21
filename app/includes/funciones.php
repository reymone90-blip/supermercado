<?php
// Funciones auxiliares usadas en todo el sistema

function redireccionar($ruta) {
    header('Location: ' . BASE_URL . 'index.php?ruta=' . $ruta);
    exit;
}

function money($numero) {
    return '$' . number_format((float)$numero, 2);
}

function url($ruta) {
    return BASE_URL . 'index.php?ruta=' . $ruta;
}

function estaLogueado() {
    return isset($_SESSION['usuario_id']);
}

function usuarioActual() {
    return $_SESSION['usuario'] ?? null;
}

function requiereLogin() {
    if (!estaLogueado()) {
        redireccionar('login');
    }
}

function requiereAdmin() {
    if ((usuarioActual()['rol'] ?? '') !== 'admin') {
        http_response_code(403);
        die('<div style="font-family:sans-serif;padding:2rem;text-align:center;">
                <h3>Acceso restringido</h3>
                <p>Solo un administrador puede acceder a esta sección.</p>
                <a href="' . url('inicio') . '">Volver al panel</a>
             </div>');
    }
}
