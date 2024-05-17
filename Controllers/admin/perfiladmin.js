// Constante para completar la ruta de la API.
const USUARIOS_API = 'services/admin/usuarios.php';
// Constantes para establecer los elementos del perfil.
const SAVE_FORM = document.getElementById('saveForm'),
    ID_USUARIO = document.getElementById('idUsuario'),
    NOMBRE_USUARIO = document.getElementById('nombreUsuario'),
    CORREO_USUARIO = document.getElementById('correoUsuario'),
    CLAVE_USUARIO = document.getElementById('claveUsuario');



// Método del evento para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    const action = 'editProfile';
    // Constante tipo objeto con los datos del formulario.
    const formData = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const responseData = await fetchData(USUARIOS_API, action, formData);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (responseData.status) {
        // Se muestra un mensaje de éxito.
        sweetAlert(1, responseData.message, true);
    } else {
        sweetAlert(2, responseData.error, false);
    }
});


/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
const openUpdate = async (id) => {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const formData = new FormData();
    formData.append('idUsuario', id);
    // Petición para obtener los datos del registro solicitado.
    const responseData = await fetchData(USUARIOS_API, 'readOne', formData);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (responseData.status) {
        // Se muestra la caja de diálogo con su título.
        SAVE_MODAL.show();
        MODAL_TITLE.textContent = 'Actualizar Usuario';
        // Se prepara el formulario.
        SAVE_FORM.reset();
        // Se inicializan los campos con los datos.
        const row = responseData.dataset;
        ID_USUARIO.value = row.id_usuario;
        NOMBRE_USUARIO.value = row.nombre_usuario;
        CLAVE_USUARIO.value = row.clave;
        CORREO_USUARIO.value = row.correo;
    } else {
        sweetAlert(2, responseData.error, false);
    }
}
