
var modal1 = document.getElementById("modalAgregarEmpleado");
var btn = document.getElementById("btnAgregarEmpleado");
var span = document.getElementsByClassName("closeAgregarEmpleado")[0];

// Abrir el modal cuando se hace clic en el botón
btn.onclick = function () {
  modal1.style.display = "block";
}

// Cerrar el modal cuando se hace clic en la "x"
span.onclick = function () {
  modal1.style.display = "none";
}

// Cerrar el modal cuando se hace clic fuera del modal
window.onclick = function (event) {
  if (event.target == modal1) {
    modal1.style.display = "none";
  }
}


//Javascript para el modal

const modal2 = document.getElementById("modalAgregarEmpleado")

const openClose = async () => {
  // Llamada a la función para mostrar un mensaje de confirmación
  const confirmed = await Swal.fire({
    icon: 'question',
    title: '¿Seguro que quieres regresar?',
    text: 'Los datos ingresados no serán almacenados',
    showCancelButton: true,
    cancelButtonText: 'Cancelar',
    confirmButtonColor: '#dc3545',
    confirmButtonText: 'Aceptar'
  });

  if (confirmed.isConfirmed) {
    $(modal2).modal('hide');
    modal2.style.display = "none";
  }
}

const openNoti = async () => {
  // Muestra una notificación de éxito utilizando SweetAlert
  Swal.fire({
    icon: 'success',
    title: '¡Éxito!',
    text: 'Se ha guardado con éxito',
    confirmButtonColor: '#dc3545',
    confirmButtonText: 'Cerrar',
    onAfterClose: () => {
      $(modal2).modal('hide');
      modal2.style.display = "none";
    }
  });
}