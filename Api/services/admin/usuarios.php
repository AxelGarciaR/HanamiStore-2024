<?php
// Se inclueye la clase de entrada
require_once('../../models/data/usuarios_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $usuario = new UsuarioData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idAdministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'searchRows':
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $producto->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$usuario->setNombreUsuario($_POST['nombreUsuario']) or
                    !$usuario->setCorreo($_POST['correoUsuario']) or
                    !$usuario->setClave($_POST['claveUsuario']) or
                    !$usuario->setImagen($_FILES['imagenUsuario'], $usuario->getFilename()) 
                ) {
                    $result['error'] = $usuario->getDataError();
                } elseif ($usuario->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto creado correctamente';
                    // Se asigna el estado del archivo después de insertar.
                    $result['fileStatus'] = Validator::saveFile($_FILES['imagenProducto'], $usuario::RUTA_IMAGEN);
                } else {
                    $result['error'] = 'Ocurrió un problema al crear el producto';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen productos registrados';
                }
                break;
            case 'readOne':
                if (!$usuario->setId($_POST['idUsuario'])) {
                    $result['error'] = $usuario->getDataError();
                } elseif ($result['dataset'] = $usuario->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Producto inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$usuario->setNombreUsuario($_POST['nombreUsuario']) or
                    !$usuario->setCorreo($_POST['correoUsuario']) or
                    !$usuario->setClave($_POST['claveUsuario']) or
                    !$usuario->setImagen($_FILES['imagenUsuario'], $usuario->getFilename())
                ) {
                    $result['error'] = $usuario->getDataError();
                } elseif ($usuario->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto modificado correctamente';
                    // Se asigna el estado del archivo después de actualizar.
                    $result['fileStatus'] = Validator::changeFile($_FILES['imagenUsuario'], $usuario::RUTA_IMAGEN, $usuario->getFilename());
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el producto';
                }
                break;
            case 'deleteRow':
                if (
                    !$usuario->setId($_POST['idUsuario']) or
                    !$usuario->setFilename()
                ) {
                    $result['error'] = $producto->getDataError();
                } elseif ($usuario->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto eliminado correctamente';
                    // Se asigna el estado del archivo después de eliminar.
                    $result['fileStatus'] = Validator::deleteFile($usuario::RUTA_IMAGEN, $usuario->getFilename());
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar el producto';
                }
                break;
            default:
                $result['error'] = 'Acción no disponible dentro de la sesión';
        }
        // Se obtiene la excepción del servidor de base de datos por si ocurrió un problema.
        $result['exception'] = Database::getException();
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('Content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}
