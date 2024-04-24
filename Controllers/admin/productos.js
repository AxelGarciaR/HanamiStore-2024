let contador = 0;

    function agregarProducto() {
      contador++;
      const container = document.querySelector('.product-card-container');

      const card = document.createElement('div');
      card.className = 'card selectable-card';
      card.dataset.id = contador;
      card.innerHTML = `
        <img src="../../Resources/images/loreal.png" class="card-img-top" alt="Producto ${contador}" width="100" height="200">
        <div class="card-body">
          <h5 class="card-title">Producto ${contador}</h5>
          <p class="card-text">Descripción del producto ${contador}.</p>
          <div class="card-actions">
            <button class="btn btn-info" onclick="mostrarModal(${contador})">Información</button>
            <button class="btn btn-danger" onclick="eliminarProducto(event)">Eliminar</button>
          </div>
        </div>
      `;

      container.appendChild(card);
    }

    function eliminarProducto(event) {
      const card = event.target.closest('.selectable-card');
      card.remove();
    }

    function mostrarModal(tarjetaId) {
      const modal = document.getElementById('modal' + tarjetaId);
      modal.style.display = 'block';
    }

    function cerrarModal(tarjetaId) {
      const modal = document.getElementById('modal' + tarjetaId);
      modal.style.display = 'none';
    }