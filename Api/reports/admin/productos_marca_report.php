<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../models/data/productos_data.php');
require_once('../../models/data/marcas_data.php');

function getAdminName($adminId)
{
    $db = new Database;
    $sql = 'SELECT nombre_usuario FROM usuarios WHERE id_usuario = ?';
    $params = array($adminId);
    if ($data = $db->getRow($sql, $params)) {
        return $data['nombre_usuario'];
    } else {
        return 'Desconocido'; // Devuelve 'Desconocido' si no se encuentra el nombre
    }
}
// Suponiendo que tienes el ID del administrador en sesión
$adminId = 1; // Ejemplo, debes obtener el ID del administrador en sesión de tu lógica de autenticación

// Obtener el nombre del administrador en sesión
$adminName = getAdminName($adminId);

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Productos por marca - Generado por: ' . $adminName);

// Se instancia el modelo Marca para obtener los datos.
$marca = new MarcasData;

// Verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataMarca = $marca->readAll()) {
    // Ancho total de la tabla
    $anchoTotal = 180;

    // Calcula la posición x inicial para centrar la tabla
    $posXInicial = ($pdf->GetPageWidth() - $anchoTotal) / 2;

    // Establece un color de relleno para los encabezados.
    $pdf->setFillColor(255, 200, 221); // Color #FFC8DD en RGB
    // Establece la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);

    // Imprime las celdas con los encabezados, centrando la tabla en la página.
    $pdf->SetX($posXInicial);
    $pdf->cell(51, 10, 'Nombre producto', 1, 0, 'C', 1);
    $pdf->cell(45, 10, 'Precio (US$)', 1, 0, 'C', 1);
    $pdf->cell(45, 10, 'Existencias', 1, 0, 'C', 1);
    $pdf->cell(45, 10, 'Subcategoria', 1, 1, 'C', 1);

    // Establece la fuente para los datos de los productos.
    $pdf->setFont('Arial', '', 11);

    // Recorre los registros fila por fila.
    foreach ($dataMarca as $rowMarca) {
        // Imprime una celda con el nombre de la marca.
        $pdf->SetX($posXInicial);
        $pdf->setFillColor(255, 240, 245); // Color más claro
        $pdf->cell(186, 10, $pdf->encodeString('Marca: ' . $rowMarca['Nombre_Marca']), 1, 1, 'C', 1);
        
        // Instancia el modelo Producto para procesar los datos.
        $producto = new ProductosData;
        // Establece la marca para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($producto->setIdMarca($rowMarca['id_Marca'])) {
            // Verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $producto->readByMarca()) {
                // Establece el color de relleno para las filas de datos.
                $pdf->setFillColor(240, 240, 240); // Color más claro

                // Recorre los registros fila por fila.
                foreach ($dataProductos as $rowProducto) {
                    // Imprime las celdas con los datos de los productos.
                    $pdf->SetX($posXInicial);
                    $pdf->cell(51, 10, $pdf->encodeString($rowProducto['Nombre_Producto']), 1, 0);
                    $pdf->cell(45, 10, '$' . number_format($rowProducto['precio_producto'], 2), 1, 0, 'C');
                    $pdf->cell(45, 10, $rowProducto['CantidadP'], 1, 0, 'C');
                    $pdf->cell(45, 10, $pdf->encodeString($rowProducto['nombre_subcategoria']), 1, 1);
                }
            } else {
                $pdf->SetX($posXInicial);
                $pdf->setFillColor(240, 240, 240); // Color más claro
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para la marca'), 1, 1, 'C', 1);
            }
        } else {
            $pdf->SetX($posXInicial);
            $pdf->setFillColor(240, 240, 240); // Color más claro
            $pdf->cell(0, 10, $pdf->encodeString('Marca incorrecta o inexistente'), 1, 1, 'C', 1);
        }
    }
} else {
    $pdf->SetX($posXInicial);
    $pdf->setFillColor(240, 240, 240); // Color más claro
    $pdf->cell(0, 10, $pdf->encodeString('No hay marcas para mostrar'), 1, 1, 'C', 1);
}

// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'productos.pdf');
?>
