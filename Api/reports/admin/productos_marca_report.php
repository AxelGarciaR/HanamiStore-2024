<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../models/data/productos_data.php');
require_once('../../models/data/marcas_data.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Productos por marca');
// Se instancia el módelo Marca para obtener los datos.
$marca = new MarcasData;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataMarca = $marca->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(200);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(51, 10, 'Nombre producto', 1, 0, 'C', 1);
    $pdf->cell(45, 10, 'Precio (US$)', 1, 0, 'C', 1);
    $pdf->cell(45, 10, 'Existencias', 1, 0, 'C', 1);
    $pdf->cell(45, 10, 'Subcategoria', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la marca.
    $pdf->setFillColor(240);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Arial', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataMarca as $rowMarca) {
        // Se imprime una celda con el nombre de la marca.
        $pdf->cell(0, 10, $pdf->encodeString('Marca: ' . $rowMarca['Nombre_Marca']), 1, 1, 'C', 1);
        // Se instancia el módelo Producto para procesar los datos.
        $producto = new ProductosData;
        // Se establece la marca para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($producto->setIdMarca($rowMarca['id_Marca'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $producto->readByMarca()) {
                // Se recorren los registros fila por fila.
                foreach ($dataProductos as $rowProducto) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(51, 10, $pdf->encodeString($rowProducto['Nombre_Producto']), 1, 0);
                    $pdf->cell(45, 10, $rowProducto['precio_producto'], 1, 0);
                    $pdf->cell(45, 10, $rowProducto['CantidadP'], 1, 0);
                    $pdf->cell(45, 10, $pdf->encodeString($rowProducto['nombre_subcategoria']), 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para la marca'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Marca incorrecta o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay marcas para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'productos.pdf');
