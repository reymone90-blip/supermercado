<?php
require_once __DIR__ . '/../models/Venta.php';

function inicio_index($pdo)
{
    $ventaModel = new Venta($pdo);
    $resumen = $ventaModel->resumenHoy();

    $totalProductos = $pdo->query("SELECT COUNT(*) FROM productos")->fetchColumn();
    $stockBajo = $pdo->query("SELECT COUNT(*) FROM productos WHERE stock_actual <= stock_minimo")->fetchColumn();

    require __DIR__ . '/../../views/layout/header.php';
    require __DIR__ . '/../../views/layout/inicio.php';
    require __DIR__ . '/../../views/layout/footer.php';
}
