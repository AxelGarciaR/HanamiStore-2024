<?php
// Se inclueye la clase de entrada
require_once('../../models/data/productos_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $producto = new ProductosData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idAdministrador'] )){
        $result['session'] = 1;
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
                    !$producto->setNombreProducto($_POST['nombreProducto']) or
                    !$producto->setDescripcionProducto($_POST['descripcionProducto']) or
                    !$producto->setPrecioProducto($_POST['precioProducto']) or
                    !$producto->setImagen($_FILES['imagenPrincipal']) or
                    !$producto->setCantidadProducto($_POST['cantidadProducto']) or
                    !$producto->setidSubcategoria($_POST['subCategoriaProducto']) or
                    !$producto->setDescuento($_POST['descuentoProducto']) or
                    !$producto->setIdMarca($_POST['marcaProducto']) 
                ) {
                    $result['error'] = $producto->getDataError();
                } elseif ($producto->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'producto creado correctamente';
                    // Se asigna el estado del archivo después de insertar.
                    $result['fileStatus'] = Validator::saveFile($_FILES['imagenPrincipal'], $producto::RUTA_IMAGEN);
                } else {
                    $result['error'] = 'Ocurrio un problema con ingresar un producto';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $producto->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen productos registrados';
                }
                break;
            case 'readOne':
                if (!$producto->setIdProducto($_POST['idProducto'])) {
                    $result['error'] = $producto->getDataError();
                } elseif ($result['dataset'] = $producto->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Producto inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$producto->setIdProducto($_POST['idProducto']) or
                    !$producto->setNombreProducto($_POST['nombreProducto']) or
                    !$producto->setDescripcionProducto($_POST['descripcionProducto']) or
                    !$producto->setPrecioProducto($_POST['precioProducto']) or
                    !$producto->setImagen($_FILES['imagenPrincipal']) or
                    !$producto->setCantidadProducto($_POST['cantidadProducto']) or
                    !$producto->setidSubcategoria($_POST['subCategoriaProducto']) or
                    !$producto->setDescuento($_POST['descuentoProducto']) or
                    !$producto->setIdMarca($_POST['marcaProducto'])
                ) {
                    $result['error'] = $producto->getDataError();
                } elseif ($producto->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto actualizado';
                    // Se asigna el estado del archivo después de actualizar.
                    $result['fileStatus'] = Validator::changeFile($_FILES['imagenPrincipal'], $producto::RUTA_IMAGEN, $producto->getFilename());
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el producto';
                }
                break;
            case 'deleteRow':
                if (!$producto->setIdProducto($_POST['idProducto'])) {
                    $result['error'] = $producto->getDataError();
                } elseif ($producto->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto eliminado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar el producto';
                }
                break;
            default:
                $result['error'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
      // Se obtiene la excepción del servidor de base de datos por si ocurrió un problema.
     $result['exception'] = Database::getException();
     // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
     header('Content-type: application/json; charset=utf-8');
     // Se imprime el resultado en formato JSON y se retorna al controlador.
     print(json_encode($result));       
    }
    
} else {
    print(json_encode('Recurso no disponible'));
}
