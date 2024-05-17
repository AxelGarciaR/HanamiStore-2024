// Función para mostrar el modal de crear orden
function mostrarModalCrearOrdenes() {
    $('#modalCrearOrdenes').modal('show');
}

// Función para mostrar el modal de editar orden
function mostrarModalEditarOrdenes(idCliente, fechaOrden, estadoOrden) {
    $('#idClienteEditar').val(idCliente);
    $('#fechaOrdenEditar').val(fechaOrden);
    $('#estadoOrdenEditar').val(estadoOrden);
    $('#modalEditarOrdenes').modal('show');
}

// Función para guardar la orden
function guardarOrdenes() {
    var fechaOrden = $('#fechaOrden').val();
    var estadoOrden = $('#estadoOrden').val();
    var idCliente = $('#idCliente').val();

    // Simulación de respuesta
    var response = {
        status: 1,
        message: "Ordenes guardada correctamente."
    };

    if (response.status === 1) {
        // Agregamos lógica para agregar una nueva tarjeta de orden en la página después de guardarla
        var nuevaTarjeta =
            `<div class="card">
                <div class="card-body">
                    <h5 class="card-title">${fechaOrden}</h5>
                    <p class="card-text">${estadoOrden}</p>
                    <div class="card-actions">
                        <button class="btn btn-info" data-toggle="modal" data-target="#modalEditarOrdenes"
                            onclick="mostrarModalEditarOrdenes('${idCliente}', '${fechaOrden}', '${estadoOrden}')">Editar</button>
                        <button class="btn btn-danger" onclick="eliminarOrdenes('${idCliente}')">Eliminar</button>
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
                $('#modalCrearOrdenes').modal('hide'); // Cerrar modal de crear orden
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

// Función para eliminar una ordenes
function eliminarOrdenes(idCliente) {
    Swal.fire({
        icon: 'question',
        title: '¿Estás seguro de eliminar esta orden?',
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
                message: "Orden eliminada correctamente."
            };

            if (response.status === 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: response.message,
                    confirmButtonColor: '#FFAFCC',
                    confirmButtonText: 'Cerrar',
                    onClose: () => {
                        location.reload(); // Recargar la página después de eliminar la orden
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

// Función para guardar la orden editada
function guardarOrdenesEditada() {
    var idCliente = $('#idClienteEditar').val();
    var fechaOrden = $('#fechaOrdenEditar').val();
    var estadoOrden = $('#estadoOrdenEditar').val();

    // Aquí podrías realizar alguna operación para guardar la orden editada, como enviar una solicitud AJAX al servidor.
    // Por ahora, simplemente mostraremos un mensaje de confirmación.
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: 'Ordenes editadas correctamente.',
        confirmButtonColor: '#FFAFCC',
        confirmButtonText: 'Cerrar',
        onClose: () => {
            $('#modalEditarOrdenes').modal('hide'); // Cerrar modal de editar ordenes
        }
    });
}

// Función para buscar orden
function buscarOrdenes() {
    var query = $('#searchInput').val();

    // Aquí deberías realizar una solicitud AJAX al servidor para buscar ordens según la consulta.
    // Por ahora, simplemente simularemos una búsqueda y mostraremos los resultados.
    // En lugar de esta simulación, puedes realizar la solicitud AJAX real como lo hiciste en el código original.
    var resultadosSimulados = `<div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Ordenes Encontrada</h5>
                                        <p class="card-text">Descripción de la orden encontrada.</p>
                                    </div>
                                </div>`;

    $('#resultadosBusqueda').html(resultadosSimulados); // Mostrar resultados simulados
}
