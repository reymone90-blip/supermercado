<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="mb-0 fw-bold">Reportes y ganancias</h4>
        <p class="text-muted mb-0">Del <?= date('d/m/Y', strtotime($desde)) ?> al <?= date('d/m/Y', strtotime($hoy)) ?></p>
    </div>

    <form method="GET" action="<?= BASE_URL ?>index.php" class="d-flex gap-2 flex-wrap align-items-end">
        <input type="hidden" name="ruta" value="reportes.index">
        <div>
            <select name="periodo" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="hoy" <?= $periodo === 'hoy' ? 'selected' : '' ?>>Hoy</option>
                <option value="semana" <?= $periodo === 'semana' ? 'selected' : '' ?>>Últimos 7 días</option>
                <option value="mes" <?= $periodo === 'mes' ? 'selected' : '' ?>>Últimos 30 días</option>
                <option value="personalizado" <?= $periodo === 'personalizado' ? 'selected' : '' ?>>Personalizado</option>
            </select>
        </div>
        <?php if ($periodo === 'personalizado'): ?>
        <div>
            <input type="date" name="desde" class="form-control form-control-sm" value="<?= $desde ?>">
        </div>
        <div>
            <input type="date" name="hasta" class="form-control form-control-sm" value="<?= $hoy ?>">
        </div>
        <button type="submit" class="btn btn-sm btn-accent">Aplicar</button>
        <?php endif; ?>
    </form>
</div>

<!-- Cards resumen -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="icon-box bg-success-soft"><i class="bi bi-receipt"></i></div>
            <div class="stat-value"><?= $resumen['cantidad'] ?></div>
            <div class="stat-label">Ventas realizadas</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="icon-box bg-accent-soft"><i class="bi bi-cash-stack"></i></div>
            <div class="stat-value"><?= money($resumen['total']) ?></div>
            <div class="stat-label">Total vendido</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="icon-box bg-warning-soft"><i class="bi bi-graph-up-arrow"></i></div>
            <div class="stat-value"><?= money($resumen['ganancia']) ?></div>
            <div class="stat-label">Ganancia bruta</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="icon-box bg-danger-soft"><i class="bi bi-percent"></i></div>
            <div class="stat-value"><?= number_format($margen, 1) ?>%</div>
            <div class="stat-label">Margen promedio</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <!-- Gráfica de ventas por día -->
    <div class="col-lg-8">
        <div class="panel h-100">
            <div class="panel-title"><i class="bi bi-graph-up text-primary"></i> Ventas y ganancia por día</div>
            <?php if (empty($ventasPorDia)): ?>
                <p class="text-muted text-center py-5 mb-0">No hay ventas registradas en este período.</p>
            <?php else: ?>
                <canvas id="graficaVentas" height="90"></canvas>
            <?php endif; ?>
        </div>
    </div>

    <!-- Stock bajo -->
    <div class="col-lg-4">
        <div class="panel h-100">
            <div class="panel-title"><i class="bi bi-exclamation-triangle-fill text-danger"></i> Stock bajo</div>
            <?php if (empty($stockBajo)): ?>
                <p class="text-muted text-center py-4 mb-0">Todo el inventario está en buen nivel.</p>
            <?php else: ?>
                <div style="max-height:260px; overflow-y:auto;">
                    <?php foreach ($stockBajo as $p): ?>
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <div class="fw-semibold small"><?= htmlspecialchars($p['nombre']) ?></div>
                            <div class="text-muted small"><?= htmlspecialchars($p['sku']) ?></div>
                        </div>
                        <span class="badge-stock-bajo"><?= $p['stock_actual'] ?> / <?= $p['stock_minimo'] ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Productos más vendidos -->
    <div class="col-lg-7">
        <div class="panel p-0">
            <div class="panel-title px-3 pt-3"><i class="bi bi-trophy-fill text-warning"></i> Productos más vendidos</div>
            <?php if (empty($masVendidos)): ?>
                <p class="text-muted text-center py-4">Sin datos en este período.</p>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr><th>Producto</th><th class="text-end">Unidades</th><th class="text-end">Vendido</th><th class="text-end">Ganancia</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($masVendidos as $m): ?>
                        <tr>
                            <td class="fw-semibold small"><?= htmlspecialchars($m['nombre']) ?></td>
                            <td class="text-end"><?= $m['unidades'] ?></td>
                            <td class="text-end"><?= money($m['total_vendido']) ?></td>
                            <td class="text-end text-success fw-semibold"><?= money($m['ganancia']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Ganancia por categoría -->
    <div class="col-lg-5">
        <div class="panel p-0">
            <div class="panel-title px-3 pt-3"><i class="bi bi-tags-fill text-primary"></i> Ganancia por categoría</div>
            <?php if (empty($porCategoria)): ?>
                <p class="text-muted text-center py-4">Sin datos en este período.</p>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr><th>Categoría</th><th class="text-end">Vendido</th><th class="text-end">Ganancia</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($porCategoria as $c): ?>
                        <tr>
                            <td class="fw-semibold small"><?= htmlspecialchars($c['categoria']) ?></td>
                            <td class="text-end"><?= money($c['total_vendido']) ?></td>
                            <td class="text-end text-success fw-semibold"><?= money($c['ganancia']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if (!empty($ventasPorDia)): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('graficaVentas');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_map(fn($d) => date('d/m', strtotime($d['dia'])), $ventasPorDia)) ?>,
        datasets: [
            {
                label: 'Total vendido',
                data: <?= json_encode(array_map(fn($d) => (float)$d['total'], $ventasPorDia)) ?>,
                backgroundColor: '#4f6ef7',
                borderRadius: 6,
            },
            {
                label: 'Ganancia',
                data: <?= json_encode(array_map(fn($d) => (float)$d['ganancia'], $ventasPorDia)) ?>,
                backgroundColor: '#22c55e',
                borderRadius: 6,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } },
        scales: { y: { beginAtZero: true } }
    }
});
</script>
<?php endif; ?>
