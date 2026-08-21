<div class="mb-4">
    <h4 class="mb-0 fw-bold">Editar usuario</h4>
    <p class="text-muted mb-0"><?= htmlspecialchars($usuario['nombre']) ?></p>
</div>

<div class="panel" style="max-width:560px;">
    <?php if ($error): ?>
        <div class="alert alert-danger py-2 small"><i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= url('usuarios.editar') ?>&id=<?= $usuario['id'] ?>">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nombre completo</label>
                <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Usuario</label>
                <input type="text" name="usuario" class="form-control" value="<?= htmlspecialchars($usuario['usuario']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nueva contraseña</label>
                <input type="password" name="clave" class="form-control" placeholder="Dejar en blanco para no cambiarla">
            </div>
            <div class="col-md-6">
                <label class="form-label">Rol</label>
                <select name="rol" class="form-select" required <?= $usuario['id'] == usuarioActual()['id'] ? 'disabled' : '' ?>>
                    <option value="cajero" <?= $usuario['rol'] === 'cajero' ? 'selected' : '' ?>>Cajero</option>
                    <option value="almacen" <?= $usuario['rol'] === 'almacen' ? 'selected' : '' ?>>Almacén</option>
                    <option value="admin" <?= $usuario['rol'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                </select>
                <?php if ($usuario['id'] == usuarioActual()['id']): ?>
                    <input type="hidden" name="rol" value="<?= $usuario['rol'] ?>">
                    <small class="text-muted">No puedes cambiar tu propio rol</small>
                <?php endif; ?>
            </div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-accent px-4"><i class="bi bi-check-circle"></i> Actualizar</button>
            <a href="<?= url('usuarios.listar') ?>" class="btn btn-light">Cancelar</a>
        </div>
    </form>
</div>
