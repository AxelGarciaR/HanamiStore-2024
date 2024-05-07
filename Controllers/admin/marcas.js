// Función para mostrar el modal de crear marca
function mostrarModalCrearMarca() {
    $('#modalCrearMarca').modal('show');
}

// Función para guardar la marca (puedes implementar lógica de guardado según tu necesidad)
function guardarMarca() {
    // Aquí puedes agregar la lógica para guardar la marca
    // Después de guardar, puedes mostrar una alerta de éxito
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: 'La marca se ha guardado correctamente.',
        confirmButtonColor: '#FFAFCC',
        confirmButtonText: 'Cerrar',
        onAfterClose: () => {
            $('#modalCrearMarca').modal('hide');
        }
    });
}

// Función para eliminar una marca
function eliminarMarca(event) {
    Swal.fire({
        icon: 'question',
        title: '¿Estás seguro de eliminar esta marca?',
        text: 'Esta acción no se puede deshacer.',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#FFAFCC',
        confirmButtonText: 'Eliminar',
    }).then((result) => {
        if (result.isConfirmed) {
            // Aquí puedes agregar la lógica para eliminar la marca
            // Después de eliminar, puedes mostrar una alerta de éxito
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'La marca se ha eliminado correctamente.',
                confirmButtonColor: '#FFAFCC',
                confirmButtonText: 'Cerrar',
            });
        }
    });
}
