<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">Nueva compra</h4>
        <p class="text-muted mb-0">Registra la mercancía que entra al inventario</p>
    </div>
    <a href="<?= url('compras.listar') ?>" class="btn btn-light"><i class="bi bi-clock-history"></i> Historial</a>
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <input type="text" id="buscador" class="form-control mb-3" placeholder="Buscar producto por nombre o SKU...">

        <div class="row g-3" id="gridProductos">
            <?php foreach ($productos as $p): ?>
            <div class="col-6 col-md-4 producto-item"
                 data-nombre="<?= strtolower(htmlspecialchars($p['nombre'])) ?>"
                 data-sku="<?= strtolower(htmlspecialchars($p['sku'])) ?>">
                <div class="pos-product-card btn-agregar"
                     data-id="<?= $p['id'] ?>"
                     data-nombre="<?= htmlspecialchars($p['nombre']) ?>"
                     data-costo="<?= $p['costo'] ?>">
                    <div class="d-flex align-items-center justify-content-center mb-2" style="height:44px;">
                        <i class="bi bi-box-seam-fill fs-3 text-secondary opacity-50"></i>
                    </div>
                    <div class="fw-semibold small text-truncate"><?= htmlspecialchars($p['nombre']) ?></div>
                    <div class="text-muted small mb-1"><?= htmlspecialchars($p['sku']) ?></div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="precio">Costo: <?= money($p['costo']) ?></span>
                        <span class="badge bg-light text-dark">Stock: <?= $p['stock_actual'] ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="panel">
            <div class="panel-title"><i class="bi bi-bag-plus-fill text-primary"></i> Detalle de compra</div>

            <div id="carritoVacio" class="text-center text-muted py-5">
                <i class="bi bi-inbox fs-1 opacity-25"></i>
                <p class="mb-0 mt-2">Agrega productos a la compra</p>
            </div>

            <div class="table-responsive">
                <table class="table table-modern mb-0" id="tablaCarrito" style="display:none;">
                    <thead>
                        <tr><th>Producto</th><th>Cant.</th><th>Costo c/u</th><th class="text-end">Subtotal</th><th></th></tr>
                    </thead>
                    <tbody id="carritoBody"></tbody>
                </table>
            </div>

            <hr>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Total de la compra</span>
                <h3 class="fw-bold mb-0 text-accent">$<span id="total">0.00</span></h3>
            </div>

            <form method="POST" action="<?= url('compras.procesar') ?>" id="formCompra">
                <input type="hidden" name="carrito" id="carritoInput">
                <label class="form-label">Proveedor</label>
                <select name="proveedor_id" class="form-select mb-3">
                    <option value="">-- Sin especificar --</option>
                    <?php foreach ($proveedores as $prov): ?>
                        <option value="<?= $prov['id'] ?>"><?= htmlspecialchars($prov['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-accent w-100 py-2"><i class="bi bi-check-circle-fill"></i> Registrar compra</button>
            </form>
        </div>
    </div>
</div>

<script>
let carrito = {};

document.querySelectorAll('.btn-agregar').forEach(card => {
    card.addEventListener('click', () => {
        const id = card.dataset.id;
        if (!carrito[id]) {
            carrito[id] = {
                nombre: card.dataset.nombre,
                costo: parseFloat(card.dataset.costo),
                cantidad: 0
            };
        }
        carrito[id].cantidad++;
        renderCarrito();
    });
});

document.getElementById('buscador').addEventListener('input', (e) => {
    const texto = e.target.value.toLowerCase();
    document.querySelectorAll('.producto-item').forEach(item => {
        const coincide = item.dataset.nombre.includes(texto) || item.dataset.sku.includes(texto);
        item.style.display = coincide ? '' : 'none';
    });
});

function renderCarrito() {
    const body = document.getElementById('carritoBody');
    const vacio = document.getElementById('carritoVacio');
    const tabla = document.getElementById('tablaCarrito');
    body.innerHTML = '';
    let total = 0;
    const items = Object.keys(carrito);

    vacio.style.display = items.length ? 'none' : '';
    tabla.style.display = items.length ? '' : 'none';

    for (const id of items) {
        const item = carrito[id];
        const subtotal = item.cantidad * item.costo;
        total += subtotal;
        body.innerHTML += `
            <tr>
                <td class="fw-semibold small">${item.nombre}</td>
                <td>
                    <div class="d-flex align-items-center gap-1">
                        <button type="button" class="btn btn-sm btn-light" onclick="cambiarCantidad(${id}, -1)">-</button>
                        <span>${item.cantidad}</span>
                        <button type="button" class="btn btn-sm btn-light" onclick="cambiarCantidad(${id}, 1)">+</button>
                    </div>
                </td>
                <td>
                    <input type="number" step="0.01" value="${item.costo}" class="form-control form-control-sm" style="width:90px"
                           onchange="cambiarCosto(${id}, this.value)">
                </td>
                <td class="text-end fw-semibold">$${subtotal.toFixed(2)}</td>
                <td class="text-end"><button type="button" class="btn btn-sm btn-soft-danger" onclick="quitar(${id})"><i class="bi bi-x-lg"></i></button></td>
            </tr>`;
    }
    document.getElementById('total').textContent = total.toFixed(2);
    document.getElementById('carritoInput').value = JSON.stringify(carrito);
}

function cambiarCantidad(id, delta) {
    const item = carrito[id];
    const nueva = item.cantidad + delta;
    if (nueva <= 0) { delete carrito[id]; }
    else { item.cantidad = nueva; }
    renderCarrito();
}

function cambiarCosto(id, valor) {
    carrito[id].costo = parseFloat(valor) || 0;
    renderCarrito();
}

function quitar(id) {
    delete carrito[id];
    renderCarrito();
}

document.getElementById('formCompra').addEventListener('submit', (e) => {
    if (Object.keys(carrito).length === 0) {
        e.preventDefault();
        alert('Agrega al menos un producto a la compra');
    }
});
</script>
