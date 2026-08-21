<?php
require_once __DIR__ . '/../models/Venta.php';
require_once __DIR__ . '/../models/Producto.php';

function reportes_index($pdo)
{
    $ventaModel = new Venta($pdo);
    $productoModel = new Producto($pdo);

    // Filtro de período: por defecto, últimos 30 días
    $periodo = $_GET['periodo'] ?? 'mes';
    $hoy = date('Y-m-d');

    switch ($periodo) {
        case 'hoy':
            $desde = $hoy;
            break;
        case 'semana':
            $desde = date('Y-m-d', strtotime('-6 days'));
            break;
        case 'personalizado':
            $desde = $_GET['desde'] ?? date('Y-m-d', strtotime('-30 days'));
            $hoy = $_GET['hasta'] ?? $hoy;
            break;
        case 'mes':
        default:
            $desde = date('Y-m-d', strtotime('-29 days'));
            break;
    }

    $resumen = $ventaModel->resumenPeriodo($desde, $hoy);
    $ventasPorDia = $ventaModel->ventasPorDia($desde, $hoy);
    $masVendidos = $ventaModel->productosMasVendidos($desde, $hoy, 8);
    $porCategoria = $ventaModel->gananciaPorCategoria($desde, $hoy);
    $stockBajo = $productoModel->stockBajo();

    $margen = $resumen['total'] > 0 ? ($resumen['ganancia'] / $resumen['total']) * 100 : 0;

    require __DIR__ . '/../../views/layout/header.php';
    require __DIR__ . '/../../views/reportes/index.php';
    require __DIR__ . '/../../views/layout/footer.php';
}
