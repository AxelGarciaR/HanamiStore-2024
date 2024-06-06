<?php
// Se incluye la clase de entrada
require_once('../../models/data/categoria_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $categoria = new CategoriaData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_Categoria'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'searchRows':
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $categoria->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                if (!$categoria->setNombreCategoria($_POST['nombreCategoria'])) {
                    $result['error'] = $categoria->getDataError();
                } elseif ($categoria->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Categoria creada correctamente';
                } else {
                    $result['error'] = 'Ocurrio un problema con ingresar una categoria';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $categoria->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen categorias registradas';
                }
                break;
            case 'newCategoria':
                if ($result['dataset'] = $categoria->newCategoria()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen categorias registradas';
                }
                break;
            case 'readOne':
                if (!$categoria->setId($_POST['id_Categoria'])) {
                    $result['error'] = $categoria->getDataError();
                } elseif ($result['dataset'] = $categoria->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Categoria inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$categoria->setId($_POST['id_Categoria']) or
                    !$categoria->setNombreCategoria($_POST['nombreCategoria'])
                ) {
                    $result['error'] = $categoria->getDataError();
                } elseif ($categoria->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Categoria actualizada';
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar la categoria';
                }
                break;
            case 'deleteRow':
                if (!$categoria->setId($_POST['id_Categoria'])) {
                    $result['error'] = $categoria->getDataError();
                } elseif ($categoria->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Categoria eliminada correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar la categoria';
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
?>
