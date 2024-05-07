let contador = 0;

function agregarProducto() {
  contador++;
  const container = document.querySelector('.product-card-container');

  const card = document.createElement('div');
  card.className = 'card selectable-card';
  card.dataset.id = contador;
  card.innerHTML = `
    <img src="../../Resources/images/loreal.png" class="card-img-top" alt="Producto 1" width="100" height="200">
    <div class="card-body">
      <h5 class="card-title">Producto 1</h5>
      <p class="card-text">Descripción del producto 1.</p>
      <p class="card-text">precio 1.</p>
      <p class="card-text">cantidad 1.</p>
      <div class="card-actions">
        <button class="btn btn-info rosado-btn" onclick="mostrarModal(1)">Editar</button>
        <button class="btn btn-danger" onclick="confirmarEliminar(event)">Eliminar</button>
      </div>
    </div>
  </div>`;

  container.appendChild(card);
}

function confirmarEliminar(event) {
  const confirmed = confirm("¿Estás seguro que quieres eliminar este producto?");
  if (confirmed) {
    eliminarProducto(event);
  }
}

function eliminarProducto(event) {
  const card = event.target.closest('.selectable-card');
  card.remove();
}
