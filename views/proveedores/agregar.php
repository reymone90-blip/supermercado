<div class="mb-4">
    <h4 class="mb-0 fw-bold">Nuevo proveedor</h4>
    <p class="text-muted mb-0">Registra los datos de contacto</p>
</div>

<div class="panel" style="max-width:640px;">
    <form method="POST" action="<?= url('proveedores.agregar') ?>">
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Persona de contacto</label>
                <input type="text" name="contacto" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label">Dirección</label>
                <input type="text" name="direccion" class="form-control">
            </div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-accent px-4"><i class="bi bi-check-circle"></i> Guardar</button>
            <a href="<?= url('proveedores.listar') ?>" class="btn btn-light">Cancelar</a>
        </div>
    </form>
</div>
