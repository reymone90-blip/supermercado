<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">Usuarios</h4>
        <p class="text-muted mb-0"><?= count($usuarios) ?> cuenta(s) registradas</p>
    </div>
    <a href="<?= url('usuarios.agregar') ?>" class="btn btn-accent"><i class="bi bi-plus-circle"></i> Nuevo usuario</a>
</div>

<div class="panel p-0">
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td class="fw-semibold">
                        <?= htmlspecialchars($u['nombre']) ?>
                        <?php if ($u['id'] == usuarioActual()['id']): ?>
                            <span class="badge bg-accent-soft ms-1">Tú</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-muted">@<?= htmlspecialchars($u['usuario']) ?></td>
                    <td>
                        <?php
                        $colores = ['admin' => 'bg-danger-soft', 'cajero' => 'bg-accent-soft', 'almacen' => 'bg-warning-soft'];
                        $clase = $colores[$u['rol']] ?? 'bg-accent-soft';
                        ?>
                        <span class="badge <?= $clase ?>"><?= ucfirst($u['rol']) ?></span>
                    </td>
                    <td>
                        <?php if ($u['activo']): ?>
                            <span class="badge bg-success-soft">Activo</span>
                        <?php else: ?>
                            <span class="badge bg-danger-soft">Inactivo</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-end">
                        <a href="<?= url('usuarios.editar') ?>&id=<?= $u['id'] ?>" class="btn btn-sm btn-soft-primary"><i class="bi bi-pencil-fill"></i></a>
                        <?php if ($u['id'] != usuarioActual()['id']): ?>
                            <a href="<?= url('usuarios.toggle') ?>&id=<?= $u['id'] ?>" class="btn btn-sm <?= $u['activo'] ? 'btn-soft-danger' : 'btn-soft-primary' ?>"
                               onclick="return confirm('¿<?= $u['activo'] ? 'Desactivar' : 'Activar' ?> este usuario?')">
                                <i class="bi bi-<?= $u['activo'] ? 'slash-circle' : 'check-circle' ?>"></i>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
