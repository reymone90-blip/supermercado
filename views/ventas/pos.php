<div class="mb-4">
    <h4 class="mb-0 fw-bold">Punto de venta</h4>
    <p class="text-muted mb-0">Selecciona productos para agregarlos al carrito</p>
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="input-group mb-3">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
            <input type="text" id="buscador" class="form-control border-start-0" placeholder="Buscar producto por nombre o SKU...">
        </div>

        <div class="row g-3" id="gridProductos">
            <?php foreach ($productos as $p): ?>
            <div class="col-6 col-md-4 producto-item"
                 data-nombre="<?= strtolower(htmlspecialchars($p['nombre'])) ?>"
                 data-sku="<?= strtolower(htmlspecialchars($p['sku'])) ?>">
                <div class="pos-product-card btn-agregar"
                     data-id="<?= $p['id'] ?>"
                     data-nombre="<?= htmlspecialchars($p['nombre']) ?>"
                     data-precio="<?= $p['precio_venta'] ?>"
                     data-costo="<?= $p['costo'] ?>"
                     data-stock="<?= $p['stock_actual'] ?>">
                    <div class="d-flex align-items-center justify-content-center mb-2" style="height:44px;">
                        <i class="bi bi-box-seam-fill fs-3 text-secondary opacity-50"></i>
                    </div>
                    <div class="fw-semibold small text-truncate"><?= htmlspecialchars($p['nombre']) ?></div>
                    <div class="text-muted small mb-1"><?= htmlspecialchars($p['sku']) ?></div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="precio"><?= money($p['precio_venta']) ?></span>
                        <span class="badge bg-light text-dark"><?= $p['stock_actual'] ?> u.</span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="panel">
            <div class="panel-title"><i class="bi bi-cart-fill text-primary"></i> Carrito</div>

            <div id="carritoVacio" class="text-center text-muted py-5">
                <i class="bi bi-cart-x fs-1 opacity-25"></i>
                <p class="mb-0 mt-2">Aún no has agregado productos</p>
            </div>

            <div class="table-responsive">
                <table class="table table-modern mb-0" id="tablaCarrito" style="display:none;">
                    <thead>
                        <tr><th>Producto</th><th>Cant.</th><th class="text-end">Subtotal</th><th></th></tr>
                    </thead>
                    <tbody id="carritoBody"></tbody>
                </table>
            </div>

            <hr>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Total a pagar</span>
                <h3 class="fw-bold mb-0 text-accent">$<span id="total">0.00</span></h3>
            </div>

            <form method="POST" action="<?= url('ventas.procesar') ?>" id="formVenta">
                <input type="hidden" name="carrito" id="carritoInput">
                <label class="form-label">Método de pago</label>
                <select name="metodo_pago" class="form-select mb-3">
                    <option value="efectivo">Efectivo</option>
                    <option value="tarjeta">Tarjeta</option>
                    <option value="transferencia">Transferencia</option>
                </select>
                <button type="submit" class="btn btn-accent w-100 py-2"><i class="bi bi-check-circle-fill"></i> Cobrar venta</button>
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
                precio: parseFloat(card.dataset.precio),
                costo: parseFloat(card.dataset.costo),
                stock: parseInt(card.dataset.stock),
                cantidad: 0
            };
        }
        if (carrito[id].cantidad < carrito[id].stock) {
            carrito[id].cantidad++;
        } else {
            alert('No hay más stock disponible');
        }
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
        const subtotal = item.cantidad * item.precio;
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
    else if (nueva <= item.stock) { item.cantidad = nueva; }
    renderCarrito();
}

function quitar(id) {
    delete carrito[id];
    renderCarrito();
}

document.getElementById('formVenta').addEventListener('submit', (e) => {
    if (Object.keys(carrito).length === 0) {
        e.preventDefault();
        alert('Agrega al menos un producto al carrito');
    }
});
</script>
