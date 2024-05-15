<?php
// Se incluye la clase de entrada
require_once('../../models/data/marcas_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $marca = new MarcasData;
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
                } elseif ($result['dataset'] = $marca->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$marca->setNombreMarca($_POST['nombreMarca']) or
                    !$marca->setLogoMarca($_POST['logoMarca'], $marca->getFilename())
                ) {
                    $result['error'] = $marca->getDataError();
                } elseif ($marca->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Marca creada correctamente';
                    // Se asigna el estado del archivo después de insertar.
                    $result['fileStatus'] = Validator::saveFile($_FILES['logoMarca'], $marca::RUTA_IMAGEN);
                } else {
                    $result['error'] = 'Ocurrió un problema al ingresar la marca';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $marca->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen marcas registradas';
                }
                break;
            case 'readOne':
                if (!$marca->setIdMarca($_POST['idMarca'])) {
                    $result['error'] = $marca->getDataError();
                } elseif ($result['dataset'] = $marca->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Marca inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$marca->setIdMarca($_POST['idMarca']) or
                    !$marca->setNombreMarca($_POST['nombreMarca']) or
                    !$marca->setLogoMarca($_POST['logoMarca'], $marca->getFilename())
                ) {
                    $result['error'] = $marca->getDataError();
                } elseif ($marca->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Marca actualizada';
                    // Se asigna el estado del archivo después de actualizar.
                    $result['fileStatus'] = Validator::changeFile($_FILES['logoMarca'], $marca::RUTA_IMAGEN, $marca->getFilename());
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar la marca';
                }
                break;
            case 'deleteRow':
                if (!$marca->setIdMarca($_POST['idMarca'])) {
                    $result['error'] = $marca->getDataError();
                } elseif ($marca->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Marca eliminada correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar la marca';
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
