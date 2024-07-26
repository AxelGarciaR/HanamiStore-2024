<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../models/data/cliente_data.php');


// Se instancia la clase para crear el reporte.
$pdf = new Report;

// Se establece el color de fondo para el encabezado del documento.
$pdf->setFillColor(255, 200, 221); // Color FFC8DD en RGB

// Se inicia el reporte con el encabezado del documento y el nombre del administrador.
$pdf->startReport('Reporte de clientes registrados');

// Se instancia el modelo de clientes para obtener los datos.
$cliente = new ClienteData;

// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataCliente = $cliente->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(255, 200, 221); // Color FFC8DD en RGB
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(25, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Apellido', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Perfil', 1, 0, 'C', 1);
    $pdf->cell(50, 10, 'Correo', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Direccion', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Estado', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar los datos de los clientes.
    $pdf->setFillColor(255, 240, 245); // Un color de relleno más claro para las filas
    // Se establece la fuente para los datos de los clientes.
    $pdf->setFont('Arial', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataCliente as $rowCliente) {
        ($rowCliente['estado']) ? $estado = 'Activo' : $estado = 'Inactivo';
        // Se imprimen las celdas con los datos de los clientes.
        $pdf->cell(25, 10, $pdf->encodeString($rowCliente['nombre_cliente']), 1, 0, '', 1);
        $pdf->cell(30, 10, $pdf->encodeString($rowCliente['apellido_cliente']), 1, 0, '', 1);
        $pdf->cell(30, 10, $pdf->encodeString($rowCliente['nombre_perfil']), 1, 0, '', 1);
        $pdf->cell(50, 10, $pdf->encodeString($rowCliente['CorreoE']), 1, 0, '', 1);
        $pdf->cell(30, 10, $pdf->encodeString($rowCliente['Direccion']), 1, 0, '', 1);
        $pdf->cell(30, 10, $estado, 1, 1, '', 1);
    }
} else {
    // Si no hay clientes para mostrar, se imprime un mensaje.
    $pdf->cell(0, 10, $pdf->encodeString('No hay clientes que mostrar'), 1, 1);
}

// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'Clientes.pdf');
?>
