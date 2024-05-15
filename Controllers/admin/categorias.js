// Función para agregar una nueva fila a la tabla
function agregarFila(id, nombre) {
    var fila = '<tr>' +
                '<td>' + id + '</td>' +
                '<td>' + nombre + '</td>' +
                '<td>' +
                  '<button type="button" class="btn btn-warning btn-sm editar">Editar</button> ' +
                  '<button type="button" class="btn btn-danger btn-sm eliminar">Eliminar</button>' +
                '</td>' +
              '</tr>';
    $('#tablaCategorias').append(fila);
}

// Evento cuando se envía el formulario para crear una nueva categoría
$('#crearForm').submit(function(e) {
    e.preventDefault();
    var nombre = $('#nombreCategoria').val();
    
    // Envía los datos al servidor para crear la categoría
    $.ajax({
        type: 'POST',
        url: 'categoria_data.php?action=createRow',
        data: { nombreCategoria: nombre },
        dataType: 'json',
        success: function(response) {
            if (response.status == 1) {
                agregarFila(response.dataset.id, nombre);
                $('#crearModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.error
                });
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});

// Evento cuando se hace clic en el botón de editar en una fila
$(document).on('click', '.editar', function() {
    var fila = $(this).closest('tr');
    var id = fila.find('td:eq(0)').text(); // Obtiene el ID de la categoría
    var nombre = fila.find('td:eq(1)').text(); // Obtiene el nombre de la categoría

    // Llena el formulario de edición con los datos de la categoría seleccionada
    $('#editandoId').val(id);
    $('#editandoNombreCategoria').val(nombre);

    // Abre el modal de edición
    $('#editarModal').modal('show');
});

// Evento cuando se envía el formulario de edición de categoría
$('#editarForm').submit(function(e) {
    e.preventDefault();
    var id = $('#editandoId').val();
    var nuevoNombre = $('#editandoNombreCategoria').val();

    // Envía los datos al servidor para actualizar la categoría
    $.ajax({
        type: 'POST',
        url: 'categoria_data.php?action=updateRow',
        data: {
            idCategoria: id,
            nombreCategoria: nuevoNombre
        },
        dataType: 'json',
        success: function(response) {
            if (response.status == 1) {
                var fila = $('#tablaCategorias').find('tr:contains(' + id + ')');
                fila.find('td:eq(1)').text(nuevoNombre);

                $('#editarModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.error
                });
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});

// Evento cuando se hace clic en el botón de eliminar en una fila
$(document).on('click', '.eliminar', function() {
    var fila = $(this).closest('tr');
    var id = fila.find('td:eq(0)').text();
    
    // Envía los datos al servidor para eliminar la categoría
    $.ajax({
        type: 'POST',
        url: 'categoria_data.php?action=deleteRow',
        data: { idCategoria: id },
        dataType: 'json',
        success: function(response) {
            if (response.status == 1) {
                fila.remove();
                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.error
                });
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
