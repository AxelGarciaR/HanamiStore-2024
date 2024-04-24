document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.getElementById('navbar');
    navbar.innerHTML = /*Codigo para insertar en la plantilla de navbar*/`
      <a class="navbar-brand" href="#"><img src="../../Resources/images/HanamiLogo.png" alt="Hanami" style="width: 100px; height: 90px;"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="../../views/public/InicioPublic.html">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../views/public/DetalleProducto.html">Detalle Productos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../views/public/Carrito.html">Carrito</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../views/public/HistorialDeCompra.html">Historial de Compra</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../views/public/SobreNosotros.html">Nosotros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../views/public/IndexPublic.html">Salir</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../views/public/Categorias.html">Categorias</a>
          </li>
        </ul>
      </div>
    `;
   
  });
  
  // asignar la propiedad para que sea sticky
  document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.getElementById('navbar');
    navbar.classList.add('fixed-navbar');
  });
  