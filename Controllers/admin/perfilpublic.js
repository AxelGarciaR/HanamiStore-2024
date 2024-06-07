// Constante para completar la ruta de la API.
const PROFILE_API = 'services/public/cliente.php';
// Constante para establecer el formulario de perfil.
const PROFILE_FORM = document.getElementById('formularioPerfil');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para obtener y mostrar los datos del perfil del cliente.
    getProfile();
});



/*
*   Función asíncrona para obtener y mostrar los datos del perfil del cliente.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const getProfile = async () => {
    try {
        // Petición para obtener los datos del perfil del cliente.
        const responseData = await fetchData(PROFILE_API, 'getProfile');

        console.log(responseData.data)

        // Verificar si el objeto responseData est=== definido y tiene la propiedad 'status'.
        if (responseData.status===1) {
            // Asignar los datos del perfil del cliente a los campos del formulario.
            document.getElementById('nombreCliente').value = responseData.data.nombre_cliente;
            document.getElementById('apellidoCliente').value = responseData.data.apellido_cliente;
            document.getElementById('correoCliente').value = responseData.data.CorreoE;
            document.getElementById('direccionCliente').value = responseData.data.Direccion;
            document.getElementById('perfilCliente').value = responseData.data.nombre_perfil;
            // Limpiar el campo de contraseña por seguridad.
            document.getElementById('claveCliente').value = responseData.data.clave;
        } else {
            // Si el objeto responseData no está definido o no tiene la propiedad 'status', muestra un mensaje de error.
            throw new Error('No se pudo obtener los datos del perfil del cliente correctamente.');
        }
    } catch (error) {
        // Captura cualquier error y muestra un mensaje en la consola.
        console.error('Error al obtener los datos del perfil del cliente:', error);
        // También puedes manejar el error mostrando un mensaje al usuario si lo deseas.
    }
}

/*
*   Función asíncrona para actualizar el perfil del cliente.
*   Parámetros: formData (objeto con los datos del formulario).
*   Retorno: ninguno.
*/
const updateProfile = async (formData) => {
    try {
        // Petición para actualizar el perfil del cliente con los datos del formulario.
        const responseData = await fetchData(PROFILE_API, 'updateProfile', formData);

        // Verificar si el objeto responseData está definido y tiene la propiedad 'status'.
        if (responseData && responseData.status) {
            // Mostrar un mensaje de éxito si la actualización fue exitosa.
            alert(responseData.message);
            // Limpiar el campo de contraseña después de la actualización exitosa.
            document.getElementById('claveCliente').value = "";
        } else {
            // Si el objeto responseData no está definido o no tiene la propiedad 'status', muestra un mensaje de error.
            throw new Error('No se pudo actualizar el perfil del cliente correctamente.');
        }
    } catch (error) {
        // Captura cualquier error y muestra un mensaje en la consola.
        console.error('Error al actualizar el perfil del cliente:', error);
        // También puedes manejar el error mostrando un mensaje al usuario si lo deseas.
    }
}

// Método del evento para cuando se envía el formulario de perfil.
PROFILE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(PROFILE_FORM);
    // Petición para registrarse.
    const responseData = await fetchData(PROFILE_API, 'updateProfile', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (responseData.status) {
        console.log(responseData.data)
    } else {
        console.log(responseData.data)
    }
});

