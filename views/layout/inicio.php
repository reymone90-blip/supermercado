<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">Panel principal</h4>
        <p class="text-muted mb-0">Resumen general de la operación de hoy</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="icon-box bg-accent-soft"><i class="bi bi-box-seam-fill"></i></div>
            <div class="stat-value"><?= $totalProductos ?></div>
            <div class="stat-label">Productos activos</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="icon-box bg-success-soft"><i class="bi bi-receipt"></i></div>
            <div class="stat-value"><?= $resumen['cantidad'] ?></div>
            <div class="stat-label">Ventas hoy</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="icon-box bg-warning-soft"><i class="bi bi-cash-stack"></i></div>
            <div class="stat-value"><?= money($resumen['total']) ?></div>
            <div class="stat-label">Total vendido hoy</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="icon-box bg-danger-soft"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <div class="stat-value"><?= $stockBajo ?></div>
            <div class="stat-label">Stock bajo</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="panel">
            <div class="panel-title"><i class="bi bi-graph-up-arrow text-primary"></i> Ganancia estimada de hoy</div>
            <div class="d-flex align-items-end gap-2">
                <h2 class="fw-bold mb-0 text-success"><?= money($resumen['ganancia']) ?></h2>
                <span class="text-muted mb-1">calculado sobre <?= $resumen['cantidad'] ?> venta(s)</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel h-100">
            <div class="panel-title"><i class="bi bi-lightning-charge-fill text-warning"></i> Accesos rápidos</div>
            <a href="<?= url('ventas.pos') ?>" class="btn btn-accent w-100 mb-2"><i class="bi bi-cash-coin"></i> Nueva venta</a>
            <a href="<?= url('productos.agregar') ?>" class="btn btn-soft-primary w-100"><i class="bi bi-plus-circle"></i> Nuevo producto</a>
        </div>
    </div>
</div>
