var modal1 = document.getElementById("modalAgregarEmpleado");
var modal2 = document.getElementById("modalEditarEmpleado"); // Nuevo modal para editar
var btnAgregar = document.getElementById("btnAgregarEmpleado");
var btnEditar = document.querySelectorAll(".btnEditarEmpleado"); // Botones de editar

var span = document.getElementsByClassName("closeAgregarEmpleado")[0];
var spanEditar = document.getElementsByClassName("closeEditarEmpleado")[0]; // Nuevo span para el modal de editar

// Abrir el modal de crear empleado cuando se hace clic en el botón
btnAgregar.onclick = function () {
  modal1.style.display = "block";
}

// Cerrar el modal de crear empleado cuando se hace clic en la "x"
span.onclick = function () {
  modal1.style.display = "none";
}

// Abrir el modal de editar empleado cuando se hace clic en el botón
btnEditar.forEach(function(btn) {
  btn.onclick = function () {
    modal2.style.display = "block";
  }
});

// Cerrar el modal de editar empleado cuando se hace clic en la "x"
spanEditar.onclick = function () {
  modal2.style.display = "none";
}

// Cerrar el modal de crear empleado cuando se hace clic fuera del modal
window.onclick = function (event) {
  if (event.target == modal1) {
    modal1.style.display = "none";
  }
  if (event.target == modal2) { // Cerrar el modal de editar empleado cuando se hace clic fuera del modal
    modal2.style.display = "none";
  }
}

//Javascript para el modal de crear empleado

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
    $(modal1).modal('hide');
    modal1.style.display = "none";
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
      $(modal1).modal('hide');
      modal1.style.display = "none";
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

// Restricciones para los inputs del modal de editar empleado
const inputNombreEditar = document.getElementById('nombreUsuarioEditar');
const inputContrasenaEditar = document.getElementById('contrasenaEditar');
const inputCorreoEditar = document.getElementById('correoElectronicoEditar');

// Restricción para el input de nombre de usuario
inputNombreEditar.addEventListener('input', function() {
  if (this.value.length > 100) {
    this.value = this.value.slice(0, 100);
  }
});

// Restricción para el input de contraseña
inputContrasenaEditar.addEventListener('input', function() {
  if (this.value.length > 100) {
    this.value = this.value.slice(0, 100);
  }
});

// Restricción para el input de correo electrónico
inputCorreoEditar.addEventListener('input', function() {
  if (this.value.length > 100) {
    this.value = this.value.slice(0, 100);
  }
});
