// Función para eliminar la valoración (simulada)
function eliminarValoracion(event) {
    Swal.fire({
        icon: 'question',
        title: '¿Estás seguro de desactivar esta valoración?',
        text: 'Esta acción no se puede deshacer.',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#FFAFCC',
        confirmButtonText: 'Desactivar',
    }).then((result) => {
        if (result.isConfirmed) {
            // Llamamos a la función para eliminar la valoración pasando el evento actual
            eliminarValoracionLogica(event);
        }
    });
}

// Función para eliminar la valoración (simulada)
function eliminarValoracionLogica(event) {
    // Puedes agregar aquí la lógica real para eliminar la valoración, como eliminarla de la base de datos o de una lista
    // En este ejemplo, simplemente eliminamos la tarjeta de la valoración del DOM
    const card = event.target.closest('.card'); // Buscamos la tarjeta más cercana al botón "Desactivar valoración"
    if (card) {
        card.remove(); // Eliminamos la tarjeta de la valoración del DOM
        // Mostramos una alerta de éxito
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: 'La valoración se ha desactivado correctamente.',
            confirmButtonColor: '#FFAFCC',
            confirmButtonText: 'Cerrar',
        });
    }
}
