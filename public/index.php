<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/includes/funciones.php';

$ruta = $_GET['ruta'] ?? 'inicio';

// Rutas públicas (no requieren sesión iniciada)
$rutasPublicas = ['login', 'logout'];

if (!in_array($ruta, $rutasPublicas)) {
    requiereLogin();
}

switch ($ruta) {

    case 'login':
        require __DIR__ . '/../app/controllers/AuthController.php';
        auth_login($pdo);
        break;

    case 'logout':
        require __DIR__ . '/../app/controllers/AuthController.php';
        auth_logout();
        break;

    case 'inicio':
        require __DIR__ . '/../app/controllers/InicioController.php';
        inicio_index($pdo);
        break;

    case 'productos.listar':
        require __DIR__ . '/../app/controllers/ProductoController.php';
        productos_listar($pdo);
        break;

    case 'productos.agregar':
        require __DIR__ . '/../app/controllers/ProductoController.php';
        productos_agregar($pdo);
        break;

    case 'productos.editar':
        require __DIR__ . '/../app/controllers/ProductoController.php';
        productos_editar($pdo);
        break;

    case 'productos.eliminar':
        require __DIR__ . '/../app/controllers/ProductoController.php';
        productos_eliminar($pdo);
        break;

    case 'ventas.pos':
        require __DIR__ . '/../app/controllers/VentaController.php';
        ventas_pos($pdo);
        break;

    case 'ventas.procesar':
        require __DIR__ . '/../app/controllers/VentaController.php';
        ventas_procesar($pdo);
        break;

    case 'ventas.recibo':
        require __DIR__ . '/../app/controllers/VentaController.php';
        ventas_recibo($pdo);
        break;

    case 'proveedores.listar':
        require __DIR__ . '/../app/controllers/ProveedorController.php';
        proveedores_listar($pdo);
        break;

    case 'proveedores.agregar':
        require __DIR__ . '/../app/controllers/ProveedorController.php';
        proveedores_agregar($pdo);
        break;

    case 'proveedores.editar':
        require __DIR__ . '/../app/controllers/ProveedorController.php';
        proveedores_editar($pdo);
        break;

    case 'proveedores.eliminar':
        require __DIR__ . '/../app/controllers/ProveedorController.php';
        proveedores_eliminar($pdo);
        break;

    case 'compras.nueva':
        require __DIR__ . '/../app/controllers/CompraController.php';
        compras_nueva($pdo);
        break;

    case 'compras.procesar':
        require __DIR__ . '/../app/controllers/CompraController.php';
        compras_procesar($pdo);
        break;

    case 'compras.listar':
        require __DIR__ . '/../app/controllers/CompraController.php';
        compras_listar($pdo);
        break;

    case 'compras.detalle':
        require __DIR__ . '/../app/controllers/CompraController.php';
        compras_detalle($pdo);
        break;

    case 'usuarios.listar':
        require __DIR__ . '/../app/controllers/UsuarioController.php';
        usuarios_listar($pdo);
        break;

    case 'usuarios.agregar':
        require __DIR__ . '/../app/controllers/UsuarioController.php';
        usuarios_agregar($pdo);
        break;

    case 'usuarios.editar':
        require __DIR__ . '/../app/controllers/UsuarioController.php';
        usuarios_editar($pdo);
        break;

    case 'usuarios.toggle':
        require __DIR__ . '/../app/controllers/UsuarioController.php';
        usuarios_toggle($pdo);
        break;

    case 'reportes.index':
        require __DIR__ . '/../app/controllers/ReporteController.php';
        reportes_index($pdo);
        break;

    default:
        http_response_code(404);
        echo 'Página no encontrada';
}
