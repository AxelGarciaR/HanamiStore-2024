let contador = 0;

// Función para agregar un producto
function agregarProducto() {
  mostrarModalAgregarProducto();
}

// Función para eliminar un producto
function eliminarProducto(event) {
  const card = event.target.closest('.selectable-card');
  // Mostrar una alerta de confirmación antes de eliminar el producto
  Swal.fire({
    icon: 'question',
    title: '¿Seguro que quieres eliminar este producto?',
    text: 'Esta acción no se puede deshacer',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      card.remove();
      // Mostrar notificación de éxito
      Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: 'El producto se ha eliminado exitosamente',
        confirmButtonColor: '#FFAFCC',
        confirmButtonText: 'Cerrar'
      });
    }
  });
}

// Función para mostrar el modal de agregar producto
function mostrarModalAgregarProducto() {
  const modalAgregarProducto = document.getElementById("modalAgregarProducto");
  modalAgregarProducto.style.display = "block";
}

// Función para cerrar el modal de agregar producto
function cerrarModalAgregarProducto() {
  const modalAgregarProducto = document.getElementById("modalAgregarProducto");
  modalAgregarProducto.style.display = "none";
}

// Función para guardar un producto
function guardarProducto() {
  // Mostrar una alerta de confirmación antes de guardar el producto
  Swal.fire({
    icon: 'question',
    title: '¿Seguro que quieres guardar este producto?',
    text: 'Una vez guardado, no podrás deshacer esta acción',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Guardar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      // Aquí puedes agregar la lógica para guardar el producto en la base de datos
      // Por ahora, solo cerramos el modal
      cerrarModalAgregarProducto();

      // Mostrar notificación de éxito
      Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: 'El producto se ha guardado exitosamente',
        confirmButtonColor: '#FFAFCC',
        confirmButtonText: 'Cerrar',
        onClose: () => {
          $(modalAgregarProducto).modal('hide');
          modalAgregarProducto.style.display = "none";
        }
      });
    }
  });
}
