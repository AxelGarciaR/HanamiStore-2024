<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../models/data/categoria_data.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Reporte de categorías registrados');
// Se instancia el modelo de categorías para obtener los datos.
$categoria = new CategoriaData;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataCategoria = $categoria->readAll()) {
    // Ancho total de la tabla
    $anchoTotal = 100;

    // Calcula la posición x inicial para centrar la tabla
    $posXInicial = ($pdf->GetPageWidth() - $anchoTotal) / 2;

    // Establece un color de relleno para los encabezados.
    $pdf->setFillColor(255, 200, 221); // Color FFC8DD en RGB
    // Establece la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);
    // Imprime las celdas con los encabezados.
    $pdf->SetX($posXInicial);
    $pdf->cell(50, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(50, 10, 'Estado', 1, 1, 'C', 1);

    // Establece la fuente para los datos de las categorías.
    $pdf->setFont('Arial', '', 11);

    // Recorre los registros fila por fila.
    foreach ($dataCategoria as $rowCategoria) {
        $estado = isset($rowCategoria['estado']) ? ($rowCategoria['estado'] ? 'Activo' : 'Inactivo') : 'Desconocido';

        // Establece un color de relleno alternante para las filas de datos.
        $pdf->setFillColor(255, 240, 245); // Color más claro

        // Imprime las celdas con los datos de las categorías.
        $pdf->SetX($posXInicial);
        $pdf->cell(50, 10, $pdf->encodeString($rowCategoria['Nombre_Categoria']), 1, 0, '', 1);
        $pdf->cell(50, 10, $estado, 1, 1, '', 1);
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay categorías que mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'Categorias.pdf');
?>
