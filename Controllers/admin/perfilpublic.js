// Obtener referencias a los botones de editar
const editarBotones = document.querySelectorAll('.input-group-append img');

// Obtener referencia al botón "Guardar cambios"
const guardarCambiosButton = document.getElementById('guardarCambiosButton');

// Agregar un controlador de eventos para cada botón
editarBotones.forEach(boton => {
    boton.addEventListener('click', () => {
        // Obtener el campo de texto asociado al botón
        const input = boton.closest('.input-group').querySelector('input');
        
        // Habilitar la edición del campo de texto
        input.removeAttribute('readonly');
        
        // Agregar la clase CSS para cambiar el estilo del botón
        boton.classList.add('editar-activo');
    });
});

// Agregar un controlador de eventos para el botón "Guardar cambios"
guardarCambiosButton.addEventListener('click', () => {
    // Obtener todos los campos de texto
    const camposTexto = document.querySelectorAll('.form-control');
    
    // Crear un objeto con los datos editados
    const datosEditados = {};
    camposTexto.forEach(input => {
        input.setAttribute('readonly', 'readonly');
        datosEditados[input.name] = input.value;
    });
    
    // Remover la clase de estilo activo de los botones de editar
    editarBotones.forEach(boton => {
        boton.classList.remove('editar-activo');
    });

    // Enviar los datos al servidor usando AJAX
    guardarCambios(datosEditados);
});

function guardarCambios(datos) {
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
            // Si se confirma la acción, enviar los datos al servidor
            fetch('ruta_al_controlador_de_perfil.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'updateProfile',
                    datos: datos
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 1) {
                    Swal.fire(
                        '¡Guardado!',
                        'Tus cambios han sido guardados correctamente.',
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Error',
                        'Ocurrió un problema al guardar los cambios: ' + data.message,
                        'error'
                    );
                }
            })
            .catch(error => {
                Swal.fire(
                    'Error',
                    'Ocurrió un problema al comunicar con el servidor: ' + error,
                    'error'
                );
            });
        }
    });
}
