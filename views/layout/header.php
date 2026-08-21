<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= NOMBRE_SISTEMA ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>css/estilos.css" rel="stylesheet">
</head>
<body>

<?php $rutaActual = $_GET['ruta'] ?? 'inicio'; ?>

<aside class="sidebar" id="sidebar">
    <a href="<?= url('inicio') ?>" class="sidebar-brand">
        <i class="bi bi-shop"></i> <?= NOMBRE_SISTEMA ?>
    </a>

    <div class="sidebar-section-title">Principal</div>
    <a href="<?= url('inicio') ?>" class="nav-link <?= $rutaActual === 'inicio' ? 'active' : '' ?>">
        <i class="bi bi-grid-1x2-fill"></i> Panel principal
    </a>

    <div class="sidebar-section-title">Operación</div>
    <a href="<?= url('productos.listar') ?>" class="nav-link <?= str_starts_with($rutaActual, 'productos') ? 'active' : '' ?>">
        <i class="bi bi-box-seam-fill"></i> Productos
    </a>
    <a href="<?= url('ventas.pos') ?>" class="nav-link <?= str_starts_with($rutaActual, 'ventas') ? 'active' : '' ?>">
        <i class="bi bi-cash-coin"></i> Ventas (POS)
    </a>
    <a href="<?= url('compras.nueva') ?>" class="nav-link <?= str_starts_with($rutaActual, 'compras') ? 'active' : '' ?>">
        <i class="bi bi-bag-plus-fill"></i> Compras
    </a>
    <a href="<?= url('reportes.index') ?>" class="nav-link <?= str_starts_with($rutaActual, 'reportes') ? 'active' : '' ?>">
        <i class="bi bi-bar-chart-fill"></i> Reportes
    </a>

    <div class="sidebar-section-title">Contactos</div>
    <a href="<?= url('proveedores.listar') ?>" class="nav-link <?= str_starts_with($rutaActual, 'proveedores') ? 'active' : '' ?>">
        <i class="bi bi-truck"></i> Proveedores
    </a>

    <?php if ((usuarioActual()['rol'] ?? '') === 'admin'): ?>
    <div class="sidebar-section-title">Administración</div>
    <a href="<?= url('usuarios.listar') ?>" class="nav-link <?= str_starts_with($rutaActual, 'usuarios') ? 'active' : '' ?>">
        <i class="bi bi-people-fill"></i> Usuarios
    </a>
    <?php endif; ?>

    <div class="mt-auto pt-3">
        <a href="<?= url('logout') ?>" class="nav-link" onclick="return confirm('¿Cerrar sesión?')">
            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
        </a>
    </div>
</aside>

<div class="main-content">
    <div class="topbar d-flex align-items-center justify-content-between">
        <button class="btn btn-light d-md-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
            <i class="bi bi-list"></i>
        </button>
        <h6 class="mb-0 text-muted"><?= date('l, d \d\e F \d\e Y') ?></h6>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-accent-soft"><i class="bi bi-person-circle"></i> <?= htmlspecialchars(usuarioActual()['nombre'] ?? '') ?></span>
        </div>
    </div>

    <div class="page-wrap">
