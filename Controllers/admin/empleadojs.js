
var modal = document.getElementById("modalAgregarEmpleado");
var btn = document.getElementById("btnAgregarEmpleado");
var span = document.getElementsByClassName("closeAgregarEmpleado")[0];

// Abrir el modal cuando se hace clic en el botón
btn.onclick = function () {
  modal.style.display = "block";
}

// Cerrar el modal cuando se hace clic en la "x"
span.onclick = function () {
  modal.style.display = "none";
}

// Cerrar el modal cuando se hace clic fuera del modal
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

