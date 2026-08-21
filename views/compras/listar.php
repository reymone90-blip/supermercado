<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">Historial de compras</h4>
        <p class="text-muted mb-0"><?= count($compras) ?> compra(s) registradas</p>
    </div>
    <a href="<?= url('compras.nueva') ?>" class="btn btn-accent"><i class="bi bi-plus-circle"></i> Nueva compra</a>
</div>

<div class="panel p-0">
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Proveedor</th>
                    <th>Registrada por</th>
                    <th>Fecha</th>
                    <th class="text-end">Total</th>
                    <th class="text-end">Detalle</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($compras as $c): ?>
                <tr>
                    <td class="text-muted">#<?= $c['id'] ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($c['proveedor'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($c['usuario'] ?? '—') ?></td>
                    <td class="text-muted small"><?= $c['fecha'] ?></td>
                    <td class="text-end fw-semibold"><?= money($c['total']) ?></td>
                    <td class="text-end">
                        <a href="<?= url('compras.detalle') ?>&id=<?= $c['id'] ?>" class="btn btn-sm btn-soft-primary"><i class="bi bi-eye-fill"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
