// Constante para completar la ruta de la API.
const PROFILE_API = 'services/public/cliente.php';
// Constante para establecer el formulario de perfil.
const PROFILE_FORM = document.getElementById('formularioPerfil');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para obtener y mostrar los datos del perfil del cliente.
    getProfile();
});

// Método del evento para cuando se envía el formulario de perfil.
PROFILE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const formData = new FormData(PROFILE_FORM);
    // Llamada a la función para actualizar el perfil del cliente.
    updateProfile(formData);
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
        
        // Verificar si el objeto responseData está definido y tiene la propiedad 'status'.
        if (responseData && responseData.status) {
            // Asignar los datos del perfil del cliente a los campos del formulario.
            document.getElementById('nombreCliente').value = responseData.data.nombreCliente;
            document.getElementById('apellidoCliente').value = responseData.data.apellidoCliente;
            document.getElementById('correoCliente').value = responseData.data.correoE;
            document.getElementById('direccionCliente').value = responseData.data.direccion;
            document.getElementById('perfilCliente').value = responseData.data.nombrePerfil;
            // Limpiar el campo de contraseña por seguridad.
            document.getElementById('claveCliente').value = responseData.data.claveCliente;
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
