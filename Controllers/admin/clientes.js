// Constante para completar la ruta de la API.
const CLIENTEPRIV_API = 'services/admin/clientepriv.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('searchForm');
// Constantes para establecer los elementos de la tabla.
const TABLE_BODY = document.getElementById('tableBody'),
    ROWS_FOUND = document.getElementById('rowsFound');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Se establece el título del contenido principal.
    document.getElementById('mainTitle').textContent = 'Ver clientes';
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
        const responseData = await fetchData(CLIENTEPRIV_API, action, formData);
        
        // Verificar si el objeto responseData está definido y tiene la propiedad 'status'.
        if (responseData && responseData.status) {
            // Se recorre el conjunto de registros fila por fila.
            responseData.dataset.forEach(row => {
                // Se crean y concatenan las filas de la tabla con los datos de cada registro.
                TABLE_BODY.innerHTML += `
                <tr>
                    <td>${row.id_cliente}</td>
                    <td>${row.nombre_cliente}</td>
                    <td>${row.apellido_cliente }</td>
                    <td>${row.nombre_perfil}</td>
                    <td>${row.CorreoE}</td>
                    <td>${row.Direccion}</td>
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