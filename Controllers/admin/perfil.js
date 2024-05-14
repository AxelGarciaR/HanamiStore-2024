// alerta.js

// Función para mostrar la alerta y guardar los cambios
function guardarCambios() {
    // Utiliza SweetAlert2 para mostrar una alerta personalizada
    Swal.fire({
        title: '¿Guardar cambios?',
        text: "¡Estás a punto de guardar los cambios!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, guardar cambios',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si se confirma la acción, muestra un mensaje de éxito
            Swal.fire(
                '¡Guardado!',
                'Tus cambios han sido guardados correctamente.',
                'success'
            );
        }
    });
}

// Agrega un listener al botón "Guardar cambios" para llamar a la función guardarCambios() cuando se hace clic en él
document.getElementById("guardarCambiosButton").addEventListener("click", guardarCambios);
