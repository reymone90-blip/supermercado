<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">Productos</h4>
        <p class="text-muted mb-0"><?= count($productos) ?> producto(s) registrados</p>
    </div>
    <a href="<?= url('productos.agregar') ?>" class="btn btn-accent"><i class="bi bi-plus-circle"></i> Nuevo producto</a>
</div>

<div class="panel p-0">
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Costo</th>
                    <th>Precio Venta</th>
                    <th>Stock</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $p): ?>
                <tr>
                    <td><span class="text-muted"><?= htmlspecialchars($p['sku']) ?></span></td>
                    <td class="fw-semibold"><?= htmlspecialchars($p['nombre']) ?></td>
                    <td><?= htmlspecialchars($p['categoria'] ?? '—') ?></td>
                    <td><?= money($p['costo']) ?></td>
                    <td class="fw-semibold text-accent"><?= money($p['precio_venta']) ?></td>
                    <td>
                        <?php if ($p['stock_actual'] <= $p['stock_minimo']): ?>
                            <span class="badge-stock-bajo"><i class="bi bi-exclamation-triangle-fill"></i> <?= $p['stock_actual'] ?></span>
                        <?php else: ?>
                            <?= $p['stock_actual'] ?>
                        <?php endif; ?>
                    </td>
                    <td class="text-end">
                        <a href="<?= url('productos.editar') ?>&id=<?= $p['id'] ?>" class="btn btn-sm btn-soft-primary"><i class="bi bi-pencil-fill"></i></a>
                        <a href="<?= url('productos.eliminar') ?>&id=<?= $p['id'] ?>" class="btn btn-sm btn-soft-danger"
                           onclick="return confirm('¿Eliminar este producto?')"><i class="bi bi-trash-fill"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
