<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../models/data/ordenes_data.php');
require_once('../../models/data/cliente_data.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Reporte de ordenes registrados');
// Se instancia el módelo Categoría para obtener los datos.
$ordenes = new OrdenesData;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataOrdenes = $ordenes->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(200);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(25, 10, 'Dirección', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Fecha Orden', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Estado', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(240);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Arial', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataCliente as $rowCliente) {
        // Se imprime una celda con el nombre de la categoría.
        $pdf->cell(0, 10, $pdf->encodeString('Cliente: ' . $rowCliente['nombre_cliente']), 1, 1, 'C', 1);
        // Se instancia el módelo Producto para procesar los datos.
        $ordenes = new OrdenesData;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($ordenes->setIdOrden($rowOrdenes['id_Orden'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataOrdenes = $ordenes->readAll()) {
                // Se recorren los registros fila por fila.
                foreach ($dataOrdenes as $rowOrdenes) {
                    ($rowOrdenes['Estado_Orden']) ? $estado = 'Activo' : $estado = 'Inactivo';
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(126, 10, $pdf->encodeString($rowOrdenes['direccion']), 1, 0);
                    $pdf->cell(30, 10, $rowOrdenes['Fecha_Orden'], 1, 0);
                    $pdf->cell(30, 10, $estado, 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay ordenes para los clientes'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Orden incorrecta o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay ordenes para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'Ordenes.pdf');
