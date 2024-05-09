var modal1 = document.getElementById("modalAgregarCliente");
var btn = document.getElementById("btnAgregarCliente");
var span = document.getElementsByClassName("closeAgregarCliente")[0];

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

// Obtener todos los botones "Editar"
const btnEditarEmpleado = document.querySelectorAll('.btnEditarEmpleado');

// Agregar un event listener a cada botón "Editar"
btnEditarEmpleado.forEach(btn => {
  btn.addEventListener('click', function() {
    // Abrir el mismo modal de agregar empleado al hacer clic en el botón "Editar"
    modal1.style.display = "block";
  });
});

// Javascript para el modal
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

// Función para validar que solo se ingresen letras en los campos especificados
$(document).ready(function () {
  $('.soloLetras').on('keypress', function (e) {
      var keyCode = e.keyCode || e.which;
      var regex = /^[a-zA-Z\s]*$/;
      var isValid = regex.test(String.fromCharCode(keyCode));
      if (!isValid) {
          e.preventDefault();
          return false;
      }
  });
});
