<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">Proveedores</h4>
        <p class="text-muted mb-0"><?= count($proveedores) ?> proveedor(es) registrados</p>
    </div>
    <a href="<?= url('proveedores.agregar') ?>" class="btn btn-accent"><i class="bi bi-plus-circle"></i> Nuevo proveedor</a>
</div>

<div class="panel p-0">
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Contacto</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($proveedores as $p): ?>
                <tr>
                    <td class="fw-semibold"><?= htmlspecialchars($p['nombre']) ?></td>
                    <td><?= htmlspecialchars($p['contacto'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($p['telefono'] ?? '—') ?></td>
                    <td class="text-muted small"><?= htmlspecialchars($p['direccion'] ?? '—') ?></td>
                    <td class="text-end">
                        <a href="<?= url('proveedores.editar') ?>&id=<?= $p['id'] ?>" class="btn btn-sm btn-soft-primary"><i class="bi bi-pencil-fill"></i></a>
                        <a href="<?= url('proveedores.eliminar') ?>&id=<?= $p['id'] ?>" class="btn btn-sm btn-soft-danger"
                           onclick="return confirm('¿Eliminar este proveedor?')"><i class="bi bi-trash-fill"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
