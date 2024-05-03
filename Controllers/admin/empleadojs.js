
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
    title: '¿Seguro que quieres cancelar?',
    text: 'Los datos ingresados no serán almacenados',
    showCancelButton: true,
    cancelButtonText: 'Cancelar',
    confirmButtonColor: '#FFAFCC',
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
    confirmButtonColor: '#FFAFCC',
    confirmButtonText: 'Cerrar',
    onAfterClose: () => {
      $(modal2).modal('hide');
      modal2.style.display = "none";
    }
  });
}

// Obtener todos los botones "Eliminar"
const btnEliminarEmpleado = document.querySelectorAll('.btnEliminarEmpleado');

// Agregar un event listener a cada botón "Eliminar"
btnEliminarEmpleado.forEach(btn => {
  btn.addEventListener('click', function() {
    // Mostrar una alerta de confirmación
    Swal.fire({
      icon: 'question',
      title: '¿Estás seguro de querer eliminar este empleado?',
      text: 'Esta acción no se puede deshacer',
      showCancelButton: true,
      confirmButtonColor: '#FFAFCC',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        // Si se confirma la eliminación, obtener la fila asociada al botón y eliminarla
        const row = this.closest('tr');
        row.remove();
        // Mostrar una notificación de éxito
        Swal.fire({
          icon: 'success',
          title: 'Empleado eliminado',
          showConfirmButton: false,
          timer: 1500
        });
      }
    });
  });
});
