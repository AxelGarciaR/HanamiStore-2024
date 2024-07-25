<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../models/data/usuarios_data.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;

// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Reporte de empleados registrados');

// Se instancia el módelo de usuarios para obtener los datos.
$usuarios = new UsuarioData;

// Anchura de las celdas
$cellWidths = [25, 30, 50, 30];

// Calcular el ancho total de la tabla
$tableWidth = array_sum($cellWidths);

// Obtener el ancho de la página
$pageWidth = $pdf->GetPageWidth();

// Calcular el desplazamiento para centrar la tabla
$xOffset = ($pageWidth - $tableWidth) / 2;

// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataUsuario = $usuarios->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(255, 200, 221); // Color FFC8DD en RGB
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);

    // Establecer el desplazamiento X
    $pdf->SetX($xOffset);

    // Se imprimen las celdas con los encabezados.
    $pdf->cell($cellWidths[0], 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell($cellWidths[1], 10, 'Clave', 1, 0, 'C', 1);
    $pdf->cell($cellWidths[2], 10, 'Correo', 1, 0, 'C', 1);
    $pdf->cell($cellWidths[3], 10, 'Estado', 1, 1, 'C', 1);

    // Se establece la fuente para los datos de los usuarios.
    $pdf->setFont('Arial', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataUsuario as $rowUsuario) {
        $estado = isset($rowUsuario['estado']) ? ($rowUsuario['estado'] ? 'Activo' : 'Inactivo') : 'Desconocido';
        $clave = isset($rowUsuario['clave']) ? $rowUsuario['clave'] : 'Desconocida';
        $nombre = isset($rowUsuario['nombre_usuario']) ? $rowUsuario['nombre_usuario'] : 'Desconocido';
        $correo = isset($rowUsuario['correo']) ? $rowUsuario['correo'] : 'Desconocido';

        // Alternar color de fondo para las filas de datos
        $pdf->setFillColor(255, 240, 245); // Color más claro

        // Establecer el desplazamiento X
        $pdf->SetX($xOffset);

        // Se imprimen las celdas con los datos de los usuarios.
        $pdf->cell($cellWidths[0], 10, $pdf->encodeString($nombre), 1, 0, '', 1);
        $pdf->cell($cellWidths[1], 10, $pdf->encodeString($clave), 1, 0, '', 1);
        $pdf->cell($cellWidths[2], 10, $pdf->encodeString($correo), 1, 0, '', 1);
        $pdf->cell($cellWidths[3], 10, $estado, 1, 1, '', 1);
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay usuarios que mostrar'), 1, 1);
}

// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'Usuarios.pdf');
?>
