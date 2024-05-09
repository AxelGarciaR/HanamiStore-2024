document.addEventListener('DOMContentLoaded', function () {
  const navbar = document.getElementById('navbar');
  navbar.innerHTML = /*Codigo para insertar en la plantilla de navbar*/`
    <a class="navbar-brand" href="#"><img src="../../Resources/images/HanamiLogo.png" alt="Hanami" style="width: 100px; height: 90px;"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="marcas.html">Marcas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Productos.html">Productos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="graficas.html">Graficas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Empleado.html">Empleado</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="Clientes.html">Clientes</a>
      </li>
        <li class="nav-item">
          <a class="nav-link" href="Perfil.html">Perfil</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="Index.html">Cerrar sesion</a>
      </li>
      </ul>
    </div>
  `;

});

// asignar la propiedad para que sea sticky
document.addEventListener('DOMContentLoaded', function () {
  const navbar = document.getElementById('navbar');
  navbar.classList.add('fixed-navbar');
});
