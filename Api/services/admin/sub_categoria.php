<?php
// Se incluye la clase del modelo.
require_once('../../models/data/sub_categoria_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $subCategoria = new SubCategoriaData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idAdministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'searchRows':
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $subCategoria->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$subCategoria->setNombreSubCategoria($_POST['nombreCategoria']) or
                    !$subCategoria->setIdCategoria($_POST['nombreCategoria'])
                ) {
                    $result['error'] = $subCategoria->getDataError();
                } elseif ($subCategoria->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sub categoría creada correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al crear la sub categoría';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $subCategoria->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen categorías registradas';
                }
                break;
            case 'readOne':
                if (!$subCategoria->setId($_POST['idSubCategoria'])) {
                    $result['error'] = $subCategoria->getDataError();
                } elseif ($result['dataset'] = $subCategoria->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Sub categoría inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$subCategoria->setNombreSubCategoria($_POST['nombreSubCategoria']) or
                    !$subCategoria->setIdCategoria($_POST['nombreSubCategoria'])
                ) {
                    $result['error'] = $subCategoria->getDataError();
                } elseif ($subCategoria->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sub categoría modificada correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar la sub categoría';
                }
                break;
            case 'deleteRow':
                if (
                    !$subCategoria->setId($_POST['idSubCategoria'])
                ) {
                    $result['error'] = $subCategoria->getDataError();
                } elseif ($subCategoria->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sub categoría eliminada correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar la sub categoría';
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
