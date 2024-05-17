<?php
// Se incluye la clase de entrada
require_once('../../models/data/ordenes_data.php');


// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $orden = new OrdenesData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idAdministrador'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'searchRows':
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $orden->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$orden->setIdCliente($_POST['idCliente']) or
                    !$orden->setFechaOrden($_POST['fechaOrden']) or
                    !$orden->setEstadoOrden($_POST['estadoOrden'])
                ) {
                    $result['error'] = $orden->getDataError();
                } elseif ($orden->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Ordenes creada correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al ingresar la ordenes';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $orden->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen ordenes registradas';
                }
                break;
            case 'readOne':
                if (!$orden->setIdOrden($_POST['idOrden'])) {
                    $result['error'] = $orden->getDataError();
                } elseif ($result['dataset'] = $orden->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Orden inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$orden->setIdCliente($_POST['idCliente']) or
                    !$orden->setFechaOrden($_POST['fechaOrden']) or
                    !$orden->setEstadoOrden($_POST['estadoOrden']) or
                    !$orden->setIdOrden($_POST['idOrden'])
                ) {
                    $result['error'] = $orden->getDataError();
                } elseif ($orden->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Orden actualizada';
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar la orden';
                }
                break;
            case 'deleteRow':
                if (!$orden->setIdOrden($_POST['idOrden'])) {
                    $result['error'] = $orden->getDataError();
                } elseif ($orden->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Orden eliminada correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar la orden';
                }
                break;
            default:
                $result['error'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se obtiene la excepción del servidor de base de datos por si ocurrió un problema.
        $result['exception'] = Database::getException();
    }
} else {
    $result['error'] = 'Recurso no disponible';
}

// Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
header('Content-type: application/json; charset=utf-8');
// Se imprime el resultado en formato JSON y se retorna al controlador.
print(json_encode($result));
