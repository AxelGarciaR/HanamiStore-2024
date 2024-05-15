// Constante para completar la ruta de la API.
const CATEGORIA_API = 'services/admin/categoria.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('searchForm');
// Constantes para establecer los elementos de la tabla.
const TABLE_BODY = document.getElementById('tableBody'),
    ROWS_FOUND = document.getElementById('rowsFound');
// Constantes para establecer los elementos del componente Modal.
const SAVE_MODAL = new bootstrap.Modal('#saveModal'),
    MODAL_TITLE = document.getElementById('modalTitle');
// Constantes para establecer los elementos del formulario de guardar.
const SAVE_FORM = document.getElementById('saveForm'),
    ID_CATEGORIA = document.getElementById('idCategoria'),
    NOMBRE_CATEGORIA = document.getElementById('nombreCategoria'),
    DESCRIPCION_CATEGORIA = document.getElementById('descripcionCategoria');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Se establece el título del contenido principal.
    document.getElementById('mainTitle').textContent = 'Gestionar Categorías';
    // Llamada a la función para llenar la tabla con los registros existentes.
    fillTable();
});

// Método del evento para cuando se envía el formulario de buscar.
SEARCH_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const formData = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTable(formData);
});

// Método del evento para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    const action = ID_CATEGORIA.value ? 'updateRow' : 'createRow';
    // Constante tipo objeto con los datos del formulario.
    const formData = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const responseData = await fetchData(CATEGORIA_API, action, formData);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (responseData.status) {
        // Se cierra la caja de diálogo.
        SAVE_MODAL.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, responseData.message, true);
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();
    } else {
        sweetAlert(2, responseData.error, false);
    }
});

/*
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: formData (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
*/
const fillTable = async (formData = null) => {
    // Se inicializa el contenido de la tabla.
    ROWS_FOUND.textContent = '';
    TABLE_BODY.innerHTML = '';

    try {
        // Se verifica si hay un objeto formData y se establece la acción en consecuencia.
        const action = formData ? 'searchRows' : 'readAll';
        // Petición para obtener los registros disponibles.
        const responseData = await fetchData(CATEGORIA_API, action, formData);
        
        // Verificar si el objeto responseData está definido y tiene la propiedad 'status'.
        if (responseData && responseData.status) {
            // Se recorre el conjunto de registros fila por fila.
            responseData.dataset.forEach(row => {
                // Se crean y concatenan las filas de la tabla con los datos de cada registro.
                TABLE_BODY.innerHTML += `
                <tr>
                    <td>${row.nombreCategoria}</td>
                    <td>${row.descripcionCategoria}</td>
                    <td>
                        <button type="button" class="btn btn-info" onclick="openUpdate(${row.idCategoria})">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <button type="button" class="btn btn-danger" onclick="openDelete(${row.idCategoria})">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </td>
                </tr>
            `;
            
            });
            // Se muestra un mensaje de acuerdo con el resultado.
            ROWS_FOUND.textContent = responseData.message;
        } else {
            // Si el objeto responseData no está definido o no tiene la propiedad 'status', muestra un mensaje de error.
            throw new Error('No se pudo obtener los datos correctamente.');
        }
    } catch (error) {
        // Captura cualquier error y muestra un mensaje en la consola.
        console.error('Error al llenar la tabla:', error);
        // También puedes manejar el error mostrando un mensaje al usuario si lo deseas.
    }
}

/*
*   Función para preparar el formulario al momento de insertar un registro.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const openCreate = () => {
    // Se muestra la caja de diálogo con su título.
    SAVE_MODAL.show();
    MODAL_TITLE.textContent = 'Crear Categoría';
    // Se prepara el formulario.
    SAVE_FORM.reset();
}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
const openUpdate = async (id) => {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const formData = new FormData();
    formData.append('idCategoria', id);
    // Petición para obtener los datos del registro solicitado.
    const responseData = await fetchData(CATEGORIA_API, 'readOne', formData);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (responseData.status) {
        // Se muestra la caja de diálogo con su título.
        SAVE_MODAL.show();
        MODAL_TITLE.textContent = 'Actualizar Categoría';
        // Se prepara el formulario.
        SAVE_FORM.reset();
        // Se inicializan los campos con los datos.
        const row = responseData.dataset;
        ID_CATEGORIA.value = row.idCategoria;
        NOMBRE_CATEGORIA.value = row.nombreCategoria;
        DESCRIPCION_CATEGORIA.value = row.descripcionCategoria;
    } else {
        sweetAlert(2, responseData.error, false);
    }
}

/*
*   Función asíncrona para eliminar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
const openDelete = async (id) => {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const response = await confirmAction('¿Desea eliminar la categoría de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (response) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const formData = new FormData();
        formData.append('idCategoria', id);
        // Petición para eliminar el registro seleccionado.
        const responseData = await fetchData(CATEGORIA_API, 'deleteRow', formData);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (responseData.status) {
            // Se muestra un mensaje de éxito.
            await sweetAlert(1, responseData.message, true);
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTable();
        } else {
            sweetAlert(2, responseData.error, false);
        }
    }
}

