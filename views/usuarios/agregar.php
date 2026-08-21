<div class="mb-4">
    <h4 class="mb-0 fw-bold">Nuevo usuario</h4>
    <p class="text-muted mb-0">Crea una cuenta de acceso al sistema</p>
</div>

<div class="panel" style="max-width:560px;">
    <?php if ($error): ?>
        <div class="alert alert-danger py-2 small"><i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= url('usuarios.agregar') ?>">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nombre completo</label>
                <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Usuario</label>
                <input type="text" name="usuario" class="form-control" value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Contraseña</label>
                <input type="password" name="clave" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Rol</label>
                <select name="rol" class="form-select" required>
                    <option value="cajero">Cajero</option>
                    <option value="almacen">Almacén</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-accent px-4"><i class="bi bi-check-circle"></i> Guardar</button>
            <a href="<?= url('usuarios.listar') ?>" class="btn btn-light">Cancelar</a>
        </div>
    </form>
</div>
