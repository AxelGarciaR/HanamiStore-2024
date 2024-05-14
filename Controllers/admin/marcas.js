// Función para mostrar el modal de crear marca
function mostrarModalCrearMarca() {
    $('#modalCrearMarca').modal('show');
}

// Función para mostrar el modal de editar marca
function mostrarModalEditarMarca(idMarca, nombreMarca, descripcionMarca) {
    $('#idMarcaEditar').val(idMarca);
    $('#nombreMarcaEditar').val(nombreMarca);
    $('#descripcionMarcaEditar').val(descripcionMarca);
    $('#modalEditarMarca').modal('show');
}

// Función para guardar la marca
function guardarMarca() {
    var nombreMarca = $('#nombreMarca').val();
    var descripcionMarca = $('#descripcionMarca').val();
    var idMarca = $('#idMarca').val();

    // Simulación de respuesta
    var response = {
        status: 1,
        message: "Marca guardada correctamente."
    };

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
                $('#modalCrearMarca').modal('hide'); // Cerrar modal de crear marca
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
            // Simulación de respuesta
            var response = {
                status: 1,
                message: "Marca eliminada correctamente."
            };

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
        }
    });
}

// Función para guardar la marca editada
function guardarMarcaEditada() {
    var idMarca = $('#idMarcaEditar').val();
    var nombreMarca = $('#nombreMarcaEditar').val();
    var descripcionMarca = $('#descripcionMarcaEditar').val();

    // Aquí podrías realizar alguna operación para guardar la marca editada, como enviar una solicitud AJAX al servidor.
    // Por ahora, simplemente mostraremos un mensaje de confirmación.
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: 'Marca editada correctamente.',
        confirmButtonColor: '#FFAFCC',
        confirmButtonText: 'Cerrar',
        onClose: () => {
            $('#modalEditarMarca').modal('hide'); // Cerrar modal de editar marca
        }
    });
}

// Función para buscar marcas
function buscarMarcas() {
    var query = $('#searchInput').val();

    // Aquí deberías realizar una solicitud AJAX al servidor para buscar marcas según la consulta.
    // Por ahora, simplemente simularemos una búsqueda y mostraremos los resultados.
    // En lugar de esta simulación, puedes realizar la solicitud AJAX real como lo hiciste en el código original.
    var resultadosSimulados = `<div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Marca Encontrada</h5>
                                        <p class="card-text">Descripción de la marca encontrada.</p>
                                    </div>
                                </div>`;
    
    $('#resultadosBusqueda').html(resultadosSimulados); // Mostrar resultados simulados
}
