<?php
// Se incluye la clase del modelo.
require_once('../../models/data/cliente_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $cliente = new ClienteData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'recaptcha' => 0, 'message' => null, 'error' => null, 'exception' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como cliente para realizar las acciones correspondientes.
    if (isset($_SESSION['idCliente'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un cliente ha iniciado sesión.
        switch ($_GET['action']) {
            case 'getUser':
                if (isset($_SESSION['correoCliente'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['correoCliente'];
                } else {
                    $result['error'] = 'Correo de usuario indefinido';
                }
                break;
            case 'logOut':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión eliminada correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;
            case 'updateProfile':
                // Validar y actualizar el perfil del cliente
                $_POST = json_decode(file_get_contents('php://input'), true); // Obtener los datos enviados en el cuerpo de la solicitud
                if (
                    $cliente->setId($_SESSION['idCliente']) &&
                    $cliente->setNombre($_POST['nombreCliente']) &&
                    $cliente->setApellido($_POST['apellidoCliente']) &&
                    $cliente->setNombrePerfil($_POST['perfilCliente']) &&
                    $cliente->setCorreo($_POST['correoCliente']) &&
                    $cliente->setDireccion($_POST['direccionCliente']) &&
                    $cliente->setClave($_POST['claveCliente']) // Se añade la clave del cliente
                ) {
                    if ($cliente->editProfile()) {
                        $result['status'] = 1;
                        $result['message'] = 'Perfil actualizado correctamente';
                    } else {
                        $result['error'] = 'Ocurrió un problema al actualizar el perfil';
                    }
                } else {
                    $result['error'] = $cliente->getDataError();
                }
                break;
            case 'getProfile':
                // Obtener el perfil del cliente
                if ($cliente->setId($_SESSION['idCliente']) && $row = $cliente->readOne()) {
                    $result['status'] = 1;
                    $result['data'] = $row;
                } else {
                    $result['error'] = 'No se pudo obtener la información del perfil';
                }
                break;
            default:
                $result['error'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el cliente no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'signUp':
                $_POST = Validator::validateForm($_POST);
                if(
                    !$cliente->setNombre($_POST['nombreCliente']) or
                    !$cliente->setApellido($_POST['apellidoCliente']) or
                    !$cliente->setNombrePerfil($_POST['perfilCliente']) or
                    !$cliente->setClave($_POST['claveCliente']) or
                    !$cliente->setCorreo($_POST['correoCliente']) or
                    !$cliente->setDireccion($_POST['direccionCliente'])
                ) {
                    $result['error'] = $cliente->getDataError();
                } elseif ($_POST['claveCliente'] != $_POST['confirmarClave']) {
                    $result['error'] = 'Contraseñas diferentes';
                } elseif ($cliente->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cuenta registrada correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al registrar la cuenta';
                }
                break;
            case 'logIn':
                $_POST = Validator::validateForm($_POST);
                if (!$cliente->checkUser($_POST['correoCliente'], $_POST['claveCliente'])) {
                    $result['error'] = 'Datos incorrectos';
                } elseif ($cliente->checkStatus()) {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                } else {
                    $result['error'] = 'La cuenta ha sido desactivada';
                }
                break;
            default:
                $result['error'] = 'Acción no disponible fuera de la sesión';
        }
    }
    // Se obtiene la excepción del servidor de base de datos por si ocurrió un problema.
    $result['exception'] = Database::getException();
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('Content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
?>
