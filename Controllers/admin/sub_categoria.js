$(document).ready(function () {
    // Función para mostrar una alerta de éxito
    function mostrarAlertaExito(mensaje) {
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: mensaje,
            showConfirmButton: false,
            timer: 1500
        });
    }

    // Función para mostrar una alerta de error
    function mostrarAlertaError(mensaje) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: mensaje
        });
    }

    // Función para cargar y mostrar la tabla de subcategorías
    function cargarTablaSubCategorias() {
        $.ajax({
            url: 'sub_categoria_data.php?action=readAll', // URL para obtener todas las subcategorías
            method: 'GET',
            success: function(response) {
                if(response.status === 1) {
                    $('#tablaSubCategorias').empty(); // Limpiar la tabla antes de agregar las nuevas filas
                    response.dataset.forEach(function(subCategoria) {
                        var fila = `
                            <tr data-id="${subCategoria.id}">
                                <td class="id-subcategoria">${subCategoria.id}</td>
                                <td class="nombre">${subCategoria.nombre}</td>
                                <td class="id-categoria">${subCategoria.idCategoria}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-editar">Editar</button>
                                    <button type="button" class="btn btn-danger btn-eliminar">Eliminar</button>
                                </td>
                            </tr>
                        `;
                        $('#tablaSubCategorias').append(fila);
                    });
                } else {
                    mostrarAlertaError(response.error);
                }
            },
            error: function() {
                mostrarAlertaError('Error al cargar las subcategorías.');
            }
        });
    }

    // Llamar a la función para cargar y mostrar la tabla de subcategorías al cargar la página
    cargarTablaSubCategorias();

    // Escuchar el evento de clic en el botón "Eliminar"
    $(document).on('click', '.btn-eliminar', function() {
        var fila = $(this).closest('tr');
        var idSubCategoria = fila.data('id');

        mostrarAlertaConfirmacion('¿Estás seguro de que quieres eliminar esta subcategoría?', function() {
            $.ajax({
                url: 'sub_categoria_data.php?action=deleteRow',
                method: 'POST',
                data: { idSubCategoria: idSubCategoria },
                success: function(response) {
                    if(response.status === 1) {
                        fila.remove(); // Eliminar la fila de la tabla
                        mostrarAlertaExito(response.message);
                    } else {
                        mostrarAlertaError(response.error);
                    }
                },
                error: function() {
                    mostrarAlertaError('Error al eliminar la subcategoría.');
                }
            });
        });
    });

    // Escuchar el evento de clic en el botón "Editar"
    $(document).on('click', '.btn-editar', function() {
        var fila = $(this).closest('tr');
        var idSubCategoria = fila.data('id');
        var nombre = fila.find('.nombre').text();
        var idCategoria = fila.find('.id-categoria').text();

        // Aquí puedes abrir un modal para editar la subcategoría con los datos obtenidos
        // y luego realizar una solicitud AJAX similar a la de eliminar para actualizar los datos en la base de datos.
        // No proporcionaste el código del modal de edición, así que no puedo agregarlo aquí.
    });

    // Aquí podrías agregar más funciones para manejar la creación, edición, etc.
});
