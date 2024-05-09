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
            // Llamamos a la función para eliminar la marca pasando el evento actual
            eliminarMarcaLogica(event);
        }
    });
}

// Función para eliminar la marca (simulada)
function eliminarMarcaLogica(event) {
    // Puedes agregar aquí la lógica real para eliminar la marca, como eliminarla de la base de datos o de una lista
    // En este ejemplo, simplemente eliminamos la tarjeta de la marca del DOM
    const card = event.target.closest('.card'); // Buscamos la tarjeta más cercana al botón "Eliminar"
    if (card) {
        card.remove(); // Eliminamos la tarjeta de la marca del DOM
        // Mostramos una alerta de éxito
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: 'La marca se ha eliminado correctamente.',
            confirmButtonColor: '#FFAFCC',
            confirmButtonText: 'Cerrar',
        });
    }
}

