<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../models/data/categoria_data.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Reporte de categorias registrados');
// Se instancia el módelo de clientes para obtener los datos.
$categoria = new CategoriaData;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataCategoria = $categoria->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(200);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(25, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Estado', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre del usuario.
    $pdf->setFillColor(240);
    // Se establece la fuente para los datos de los usuarios.
    $pdf->setFont('Arial', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataCategoria as $rowCategoria) {
        $estado = isset($rowCategoria['estado']) ? ($rowCategoria['estado'] ? 'Activo' : 'Inactivo') : 'Desconocido';
        // Se imprimen las celdas con los datos de los clientes.
        $pdf->cell(25, 10, $pdf->encodeString($rowCategoria['Nombre_Categoria']), 1, 0);
        $pdf->cell(30, 10, $estado, 1, 1);
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay categorias que mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'Categorias.pdf');
?>
