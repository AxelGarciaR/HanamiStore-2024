// Constante de api de usuario
const USER_API = 'services/admin/usuarios.php';

// Constante para establecer el formulario de inicio de sesión.
const LOGIN_FORM = document.getElementById('loginForm');
const CORREO_LOGIN = document.getElementById('correoLogin');
const CLAVE_LOGIN = document.getElementById('claveLogin');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para consultar los usuarios registrados.
    const DATA = await fetchData(USER_API, 'readUsers');
    // Se comprueba si existe una sesión, de lo contrario se sigue con el flujo normal.
    if (DATA.session) {
        // Se direcciona a la página web de bienvenida.
        location.href = 'Graficas.html';
    } else if (DATA.status) {
        // Se muestra el formulario para iniciar sesión.
        LOGIN_FORM.classList.remove('d-none');
        sweetAlert(4, DATA.message, true);
    }
});

// Método del evento para cuando se envía el formulario de inicio de sesión.
LOGIN_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(LOGIN_FORM);

    // Imprimir los campos enviados del formulario
    for (let pair of FORM.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

    // Petición para iniciar sesión.
    const DATA = await fetchData(USER_API, 'logIn', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // sweetAlert(1, DATA.message, true, 'panel_principal.html');
        location.href = 'Graficas.html';
        // Evitar que el usuario regrese después de iniciar sesión
    } else {
        if (DATA.error == 'Acción no disponible dentro de la sesión') {
            await sweetAlert(4, "Ya tiene una sesión activa", true); location.href = 'Graficas.html'
        }
        else {
            await sweetAlert(2, DATA.error, false);
        }
    }
});