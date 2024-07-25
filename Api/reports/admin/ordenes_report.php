<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../models/data/ordenes_data.php');
require_once('../../models/data/cliente_data.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Reporte de órdenes registradas');
// Se instancia el modelo OrdenesData para obtener los datos.
$ordenes = new OrdenesData;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataOrdenes = $ordenes->readOrdenesReport()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(200);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(25, 10, 'NO orden', 1, 0, 'C', 1);
    $pdf->cell(40, 10, 'Apellido Cliente', 1, 0, 'C', 1);
    $pdf->cell(60, 10, 'Correo Cliente', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Fecha Orden', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Estado', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(240);
    // Se establece la fuente para los datos de las órdenes.
    $pdf->setFont('Arial', '', 11);

    $currentEstado = '';

    // Se recorren los registros fila por fila.
    foreach ($dataOrdenes as $rowOrdenes) {
        if ($rowOrdenes['Estado_Orden'] != $currentEstado) {
            $currentEstado = $rowOrdenes['Estado_Orden'];
            $pdf->cell(185, 10, $pdf->encodeString('Estado Orden: ' . $currentEstado), 1, 1, 'C', 1);
        }
        // Se imprimen las celdas con los datos de las órdenes y los clientes.
        $pdf->cell(25, 10, $rowOrdenes['id_Orden'], 1, 0);
        $pdf->cell(40, 10, $rowOrdenes['apellido_cliente'], 1, 0);
        $pdf->cell(60, 10, $rowOrdenes['CorreoE'], 1, 0);
        $pdf->cell(30, 10, $rowOrdenes['Fecha_Orden'], 1, 0);
        $pdf->cell(30, 10, $rowOrdenes['Estado_Orden'], 1, 1);
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay órdenes para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'Ordenes.pdf');
?>
