<div class="text-center mb-4">
    <div class="d-inline-flex align-items-center justify-content-center bg-success-soft rounded-circle mb-2" style="width:64px;height:64px;">
        <i class="bi bi-check-lg fs-2 text-success"></i>
    </div>
    <h4 class="fw-bold mb-0">Venta #<?= $venta['id'] ?> completada</h4>
    <p class="text-muted"><?= $venta['fecha'] ?> · <?= ucfirst($venta['metodo_pago']) ?></p>
</div>

<div class="panel mx-auto" style="max-width:600px;">
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr><th>SKU</th><th>Producto</th><th>Cant.</th><th class="text-end">Subtotal</th></tr>
            </thead>
            <tbody>
                <?php foreach ($detalle as $d): ?>
                <tr>
                    <td class="text-muted"><?= htmlspecialchars($d['sku']) ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($d['nombre']) ?></td>
                    <td><?= $d['cantidad'] ?></td>
                    <td class="text-end"><?= money($d['subtotal']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <hr>
    <div class="d-flex justify-content-between align-items-center">
        <span class="text-muted">Total</span>
        <h3 class="fw-bold mb-0 text-accent"><?= money($venta['total']) ?></h3>
    </div>
</div>

<div class="text-center mt-4">
    <a href="<?= url('ventas.pos') ?>" class="btn btn-accent px-4"><i class="bi bi-plus-circle"></i> Nueva venta</a>
</div>
