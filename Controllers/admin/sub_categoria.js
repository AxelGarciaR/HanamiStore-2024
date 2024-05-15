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
                    // Limpiar la tabla antes de agregar los nuevos datos
                    $('#tablaSubCategorias').empty();
                    // Construir las filas de la tabla con los datos recibidos del servidor
                    response.dataset.forEach(function(subCategoria) {
                        var fila = `
                            <tr>
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

    // Escuchar el evento de clic en el botón "Crear Subcategoría"
    $('#btnCrear').click(function() {
        // Aquí podrías mostrar el modal para crear una nueva subcategoría si lo deseas
        // y luego procesar el formulario de creación con una petición AJAX similar a las demás acciones.
        // No proporcionaste el código del modal de creación, así que no puedo agregarlo aquí.
    });

    // Escuchar el evento de clic en el botón "Eliminar"
    $(document).on('click', '.btn-eliminar', function() {
        var idSubCategoria = $(this).closest('tr').find('.id-subcategoria').text();
        mostrarAlertaConfirmacion('¿Estás seguro de que quieres eliminar esta subcategoría?', function() {
            $.ajax({
                url: 'sub_categoria_data.php?action=deleteRow',
                method: 'POST',
                data: { idSubCategoria: idSubCategoria },
                success: function(response) {
                    if(response.status === 1) {
                        cargarTablaSubCategorias();
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

    // Aquí podrías agregar más funciones para manejar la edición, creación, etc.
});
