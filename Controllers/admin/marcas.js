// Función para mostrar el modal de crear marca
function mostrarModalCrearMarca() {
    $('#modalCrearMarca').modal('show');
}

// Función para mostrar el modal de editar marca
function mostrarModalEditarMarca(idMarca, nombreMarca, descripcionMarca) {
    $('#idMarca').val(idMarca);
    $('#nombreMarca').val(nombreMarca);
    $('#descripcionMarca').val(descripcionMarca);
    $('#modalEditarMarca').modal('show');
}

// Función para guardar la marca
function guardarMarca() {
    var nombreMarca = $('#nombreMarca').val();
    var descripcionMarca = $('#descripcionMarca').val();
    var idMarca = $('#idMarca').val();

    $.ajax({
        type: 'POST',
        url: 'guardar_marca.php', // Ruta al script de PHP que maneja el guardado de la marca
        data: {
            idMarca: idMarca,
            nombreMarca: nombreMarca,
            descripcionMarca: descripcionMarca
        },
        success: function(response) {
            if (response.status === 1) {
                // Agregamos lógica para agregar una nueva tarjeta de marca en la página después de guardarla
                var nuevaTarjeta =
                    `<div class="card">
                        <div class="card-body">
                            <h5 class="card-title">${nombreMarca}</h5>
                            <p class="card-text">${descripcionMarca}</p>
                            <div class="card-actions">
                                <button class="btn btn-info" data-toggle="modal" data-target="#modalEditarMarca"
                                    onclick="mostrarModalEditarMarca('${idMarca}', '${nombreMarca}', '${descripcionMarca}')">Editar</button>
                                <button class="btn btn-danger" onclick="eliminarMarca('${idMarca}')">Eliminar</button>
                            </div>
                        </div>
                    </div>`;
                
                $('.product-card-container').append(nuevaTarjeta); // Agregamos la nueva tarjeta al contenedor de tarjetas

                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: response.message,
                    confirmButtonColor: '#FFAFCC',
                    confirmButtonText: 'Cerrar',
                    onClose: () => {
                        $('#modalEditarMarca').modal('hide');
                        location.reload(); // Recargar la página después de guardar la marca
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.error,
                    confirmButtonColor: '#FFAFCC',
                    confirmButtonText: 'Cerrar'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

// Función para eliminar una marca
function eliminarMarca(idMarca) {
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
            $.ajax({
                type: 'POST',
                url: 'eliminar_marca.php', // Ruta al script de PHP que maneja la eliminación de la marca
                data: {
                    idMarca: idMarca
                },
                success: function(response) {
                    if (response.status === 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: response.message,
                            confirmButtonColor: '#FFAFCC',
                            confirmButtonText: 'Cerrar',
                            onClose: () => {
                                location.reload(); // Recargar la página después de eliminar la marca
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.error,
                            confirmButtonColor: '#FFAFCC',
                            confirmButtonText: 'Cerrar'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });
}

// Función para buscar marcas
function buscarMarcas() {
    var query = $('#searchInput').val();

    $.ajax({
        type: 'POST',
        url: 'buscar_marcas.php', // Ruta al script de PHP que maneja la búsqueda de marcas
        data: {
            query: query
        },
        success: function(response) {
            $('#resultadosBusqueda').html(response); // Actualizamos el contenido de los resultados de la búsqueda
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}
