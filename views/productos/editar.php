<div class="mb-4">
    <h4 class="mb-0 fw-bold">Editar producto</h4>
    <p class="text-muted mb-0"><?= htmlspecialchars($producto['nombre']) ?></p>
</div>

<div class="panel" style="max-width:640px;">
    <form method="POST" action="<?= url('productos.editar') ?>&id=<?= $producto['id'] ?>">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">SKU</label>
                <input type="text" name="sku" class="form-control" value="<?= htmlspecialchars($producto['sku']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
            </div>
            <div class="col-12">
                <label class="form-label">Categoría</label>
                <select name="categoria_id" class="form-select">
                    <option value="">-- Ninguna --</option>
                    <?php foreach ($categorias as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= $c['id'] == $producto['categoria_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Costo</label>
                <input type="number" step="0.01" name="costo" class="form-control" value="<?= $producto['costo'] ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Precio de venta</label>
                <input type="number" step="0.01" name="precio_venta" class="form-control" value="<?= $producto['precio_venta'] ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Stock actual</label>
                <input type="number" name="stock_actual" class="form-control" value="<?= $producto['stock_actual'] ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Stock mínimo</label>
                <input type="number" name="stock_minimo" class="form-control" value="<?= $producto['stock_minimo'] ?>" required>
            </div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-accent px-4"><i class="bi bi-check-circle"></i> Actualizar</button>
            <a href="<?= url('productos.listar') ?>" class="btn btn-light">Cancelar</a>
        </div>
    </form>
</div>
