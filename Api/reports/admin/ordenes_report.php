<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../models/data/ordenes_data.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Reporte de órdenes registradas');

// Se instancia el modelo OrdenesData para obtener los datos.
$ordenes = new OrdenesData;

// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataOrdenes = $ordenes->readOrdenesReport()) {
    // Ancho total de la tabla
    $anchoTotal = 185;

    // Calcula la posición x inicial para centrar la tabla
    $posXInicial = ($pdf->GetPageWidth() - $anchoTotal) / 2;

    // Establece un color de relleno para los encabezados.
    $pdf->setFillColor(255, 200, 221); // Color #FFC8DD en RGB
    // Establece la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);
    
    // Imprime las celdas con los encabezados, centrando la tabla en la página.
    $pdf->SetX($posXInicial);
    $pdf->cell(25, 10, 'NO orden', 1, 0, 'C', 1);
    $pdf->cell(40, 10, 'Apellido Cliente', 1, 0, 'C', 1);
    $pdf->cell(60, 10, 'Correo Cliente', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Fecha Orden', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Estado', 1, 1, 'C', 1);

    // Establece la fuente para los datos de las órdenes.
    $pdf->setFont('Arial', '', 11);

    // Establece un color de relleno para las filas de datos.
    $pdf->setFillColor(255, 240, 245); // Color más claro

    $currentEstado = '';

    // Se recorren los registros fila por fila.
    foreach ($dataOrdenes as $rowOrdenes) {
        if ($rowOrdenes['Estado_Orden'] != $currentEstado) {
            $currentEstado = $rowOrdenes['Estado_Orden'];
            $pdf->SetX($posXInicial);
            $pdf->setFillColor(255, 240, 245); // Color más claro
            $pdf->cell(185, 10, $pdf->encodeString('Estado Orden: ' . $currentEstado), 1, 1, 'C', 1);
        }
        
        // Se imprime la fila de datos.
        $pdf->SetX($posXInicial);
        $pdf->cell(25, 10, $rowOrdenes['id_Orden'], 1, 0, 'C');
        $pdf->cell(40, 10, $rowOrdenes['apellido_cliente'], 1, 0, 'L');
        $pdf->cell(60, 10, $rowOrdenes['CorreoE'], 1, 0, 'L');
        $pdf->cell(30, 10, $rowOrdenes['Fecha_Orden'], 1, 0, 'C');
        $pdf->cell(30, 10, $rowOrdenes['Estado_Orden'], 1, 1, 'C');
    }
} else {
    // Si no hay datos, se imprime un mensaje.
    $pdf->SetX($posXInicial);
    $pdf->setFillColor(255, 240, 245); // Color más claro
    $pdf->cell(185, 10, $pdf->encodeString('No hay órdenes para mostrar'), 1, 1, 'C', 1);
}

// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'Ordenes.pdf');
?>
