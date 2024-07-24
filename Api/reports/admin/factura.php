<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once ('../../helpers/report.php');
// Se incluye la clase para manejar los datos de detalle de órdenes.
require_once ('../../models/handler/detalle_ordenes_handler.php');

// Inicializar la variable $idOrden
$idOrden = null;

// Verificar si hay un pedido en la sesión
if (isset($_SESSION['idOrden'])) {
    $idOrden = $_SESSION['idOrden'];
} else {
    die('No se ha especificado ningún pedido.');
}

// Se incluye la clase con las plantillas para generar reportes.
require_once ('../../helpers/report.php');
// Se incluye la clase para manejar los datos de detalle de órdenes.
require_once ('../../models/handler/detalle_ordenes_handler.php');

// Se instancia el handler para manejar los datos de detalle de órdenes.
$detalleOrdenHandler = new DetalleOrdenHandler();

// Obtener los datos del detalle de la orden usando la función factura del handler
$dataFactura = $detalleOrdenHandler->factura($idOrden);

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Factura');

// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataFactura) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(143, 194, 187);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 12);

    // Imprimir datos del cliente (ajustar según los datos disponibles en $dataFactura)
    $pdf->Cell(0, 10, '', 0, 1, 'C');
    $pdf->Ln(10);

    // Datos del cliente y pedido (ajustar según la estructura de tu función factura)
    $pdf->Cell(30, 10, 'Cliente:', 0, 0);
    $pdf->Cell(70, 10, $pdf->encodeString($dataFactura[0]['nombre_cliente'] . ' ' . $dataFactura[0]['apellido_cliente']), 0, 1);
    $pdf->Cell(30, 10, 'DUI:', 0, 0);
    $pdf->Cell(70, 10, $pdf->encodeString($dataFactura[0]['dui_cliente']), 0, 1);
    $pdf->Cell(30, 10, 'Telefono:', 0, 0);
    $pdf->Cell(70, 10, $pdf->encodeString($dataFactura[0]['telefono_cliente']), 0, 1);
    $pdf->Cell(30, 10, 'Direccion:', 0, 0);
    $pdf->Cell(70, 10, $pdf->encodeString($dataFactura[0]['direccion_cliente']), 0, 1);
    $pdf->Cell(30, 10, 'Fecha:', 0, 0);
    $pdf->Cell(70, 10, $pdf->encodeString($dataFactura[0]['fecha_compra']), 0, 1);
    $pdf->Ln(10);

    // Imprimir los encabezados de la tabla de productos
    $pdf->Cell(70, 10, 'Producto', 1, 0, 'C', 1);
    $pdf->Cell(30, 10, 'Cantidad', 1, 0, 'C', 1);
    $pdf->Cell(30, 10, 'Precio', 1, 0, 'C', 1);
    $pdf->Cell(30, 10, 'Subtotal', 1, 1, 'C', 1);

    // Se establece un color de relleno para los datos de productos.
    $pdf->setFillColor(200, 231, 226);
    // Se establece la fuente para los datos.
    $pdf->setFont('Arial', '', 11);

    $total = 0;

    // Se recorren los registros fila por fila.
    foreach ($dataFactura as $rowFactura) {
        $subtotal = $rowFactura['precio_unitario'] * $rowFactura['cantidad_producto'];
        $total += $subtotal;

        // Se imprimen las celdas con los datos de productos.
        $pdf->Cell(70, 10, $pdf->encodeString($rowFactura['nombre_producto']), 1, 0, 'L');
        $pdf->Cell(30, 10, $pdf->encodeString($rowFactura['cantidad_producto']), 1, 0, 'C');
        $pdf->Cell(30, 10, '$' . number_format($rowFactura['precio_unitario'], 2), 1, 0, 'C');
        $pdf->Cell(30, 10, '$' . number_format($subtotal, 2), 1, 1, 'C');
    }

    // Imprimir el total
    $pdf->Cell(130, 10, 'Total', 1, 0, 'R', 1);
    $pdf->Cell(30, 10, '$' . number_format($total, 2), 1, 1, 'C');
} else {
    $pdf->Cell(0, 10, $pdf->encodeString('No hay datos para mostrar'), 1, 1, 'C');
}

// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'factura.pdf');
?>