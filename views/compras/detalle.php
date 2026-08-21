<div class="mb-4">
    <h4 class="mb-0 fw-bold">Compra #<?= $compra['id'] ?></h4>
    <p class="text-muted mb-0"><?= $compra['fecha'] ?> · Proveedor: <?= htmlspecialchars($compra['proveedor'] ?? 'Sin especificar') ?></p>
</div>

<div class="panel">
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr><th>SKU</th><th>Producto</th><th>Cant.</th><th>Costo c/u</th><th class="text-end">Subtotal</th></tr>
            </thead>
            <tbody>
                <?php foreach ($detalle as $d): ?>
                <tr>
                    <td class="text-muted"><?= htmlspecialchars($d['sku']) ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($d['nombre']) ?></td>
                    <td><?= $d['cantidad'] ?></td>
                    <td><?= money($d['costo_unitario']) ?></td>
                    <td class="text-end"><?= money($d['subtotal']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <hr>
    <div class="d-flex justify-content-between align-items-center">
        <span class="text-muted">Total</span>
        <h3 class="fw-bold mb-0 text-accent"><?= money($compra['total']) ?></h3>
    </div>
</div>

<div class="mt-4">
    <a href="<?= url('compras.listar') ?>" class="btn btn-light"><i class="bi bi-arrow-left"></i> Volver al historial</a>
</div>
