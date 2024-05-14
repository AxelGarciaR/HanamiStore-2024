
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
     
     // Iterar sobre los campos de texto y establecer el atributo "readonly" en cada uno
     camposTexto.forEach(input => {
         input.setAttribute('readonly', 'readonly');
     });
     
     // Remover la clase de estilo activo de los botones de editar
     editarBotones.forEach(boton => {
         boton.classList.remove('editar-activo');
     });
 });

$(document).ready(function() {
    // Agrega un evento clic a todos los botones de "editar"
    $('span.input-group-text').click(function() {
        // Habilita el campo de texto correspondiente para edición
        $(this).closest('.input-group').find('input').removeAttr('readonly');
        // Muestra el modal de "Guardar cambios"
        $('#modalGuardarCambios').modal('show');
    });
});


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
