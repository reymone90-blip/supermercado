<div class="mb-4">
    <h4 class="mb-0 fw-bold">Nuevo producto</h4>
    <p class="text-muted mb-0">Completa los datos para registrarlo en el inventario</p>
</div>

<div class="panel" style="max-width:640px;">
    <form method="POST" action="<?= url('productos.agregar') ?>">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">SKU</label>
                <input type="text" name="sku" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label">Categoría</label>
                <select name="categoria_id" class="form-select">
                    <option value="">-- Ninguna --</option>
                    <?php foreach ($categorias as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Costo</label>
                <input type="number" step="0.01" name="costo" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Precio de venta</label>
                <input type="number" step="0.01" name="precio_venta" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Stock inicial</label>
                <input type="number" name="stock_actual" class="form-control" value="0" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Stock mínimo</label>
                <input type="number" name="stock_minimo" class="form-control" value="5" required>
            </div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-accent px-4"><i class="bi bi-check-circle"></i> Guardar</button>
            <a href="<?= url('productos.listar') ?>" class="btn btn-light">Cancelar</a>
        </div>
    </form>
</div>
