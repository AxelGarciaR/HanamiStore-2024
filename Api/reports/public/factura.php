<?php
// Incluir las clases necesarias
require_once('../../helpers/report.php');
require_once('../../models/handler/detalle_ordenes_handler.php');
require_once('../../models/data/detalle_ordenes_data.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Factura');

// Se instancia el modelo Pedido para obtener los datos.
$pedido = new DetalleOrdenData;

// Verificar si hay un pedido en la sesión
if (isset($_SESSION['idOrden'])) {
    $idPedido = $_SESSION['idOrden'];
} else {
    die('No se ha especificado ningún pedido.');
}

// Obtener los datos del detalle de la orden usando el método factura del handler
$dataFactura = $pedido->factura();

// Verificar si hay datos para mostrar en la factura
if ($dataFactura) {
    // Configurar estilos y encabezados para el reporte
    $pdf->setFillColor(143, 194, 187); // Color en RGB
    $pdf->setFont('Arial', 'B', 12);

    // Imprimir encabezados de la tabla de productos
    $pdf->setFont('Arial', 'B', 12);
    $pdf->setFillColor(143, 194, 187); // Color en RGB
    $pdf->Cell(70, 10, 'Producto', 1, 0, 'C', 1);
    $pdf->Cell(30, 10, 'Cantidad', 1, 0, 'C', 1);
    $pdf->Cell(30, 10, 'Precio', 1, 0, 'C', 1);
    $pdf->Cell(30, 10, 'Subtotal', 1, 1, 'C', 1);

    // Se establece un color de relleno para los datos de productos.
    $pdf->setFillColor(200, 231, 226);
    // Se establece la fuente para los datos.
    $pdf->setFont('Arial', '', 11);

    $total = 0;

    // Iterar sobre los datos del detalle de la orden
    foreach ($dataFactura as $rowFactura) {
        $subtotal = $rowFactura['cantidad_producto'] * $rowFactura['precio_unitario']; 
        $total += $subtotal;

        // Imprimir filas de datos de productos
        $pdf->Cell(70, 10, $pdf->encodeString($rowFactura['nombre_producto']), 1, 0, 'L', 1);
        $pdf->Cell(30, 10, $pdf->encodeString($rowFactura['cantidad_producto']), 1, 0, 'C', 1);
        $pdf->Cell(30, 10, '$' . number_format($rowFactura['precio_unitario'], 2), 1, 0, 'C', 1);
        $pdf->Cell(30, 10, '$' . number_format($subtotal, 2), 1, 1, 'C', 1);
    }

    // Imprimir el total de la orden
    $pdf->setFont('Arial', 'B', 12);
    $pdf->setFillColor(143, 194, 187); // Color en RGB
    $pdf->Cell(130, 10, 'Total', 1, 0, 'R', 1);
    $pdf->Cell(30, 10, '$' . number_format($total, 2), 1, 1, 'C', 1);

    // Imprimir los detalles del cliente
    $pdf->Ln(10); // Espacio para separar la tabla del total
    $pdf->setFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Detalles del Cliente', 0, 1, 'L');

    // Información del cliente
    foreach ($dataFactura as $rowFactura) {
        $pdf->setFont('Arial', '', 12);
        $pdf->Cell(50, 10, 'Nombre: ', 0, 0, 'L');
        $pdf->Cell(0, 10, $pdf->encodeString($rowFactura['nombre_cliente'] . ' ' . $rowFactura['apellido_cliente']), 0, 1, 'L');
        $pdf->Cell(50, 10, 'Correo: ', 0, 0, 'L');
        $pdf->Cell(0, 10, $pdf->encodeString($rowFactura['correo_cliente']), 0, 1, 'L');
        $pdf->Cell(50, 10, 'Teléfono: ', 0, 0, 'L');
        $pdf->Cell(0, 10, $pdf->encodeString($rowFactura['telefono_cliente']), 0, 1, 'L');
        $pdf->Cell(50, 10, 'Fecha de Compra: ', 0, 0, 'L');
        $pdf->Cell(0, 10, $pdf->encodeString(date('d/m/Y', strtotime($rowFactura['fecha_compra']))), 0, 1, 'L');
        break; // Solo necesitamos los detalles del cliente una vez
    }
} else {
    // Mostrar un mensaje si no hay datos para mostrar
    $pdf->Cell(0, 10, $pdf->encodeString('No hay datos para mostrar'), 1, 1, 'C');
}

// Generar el archivo PDF y enviarlo al navegador
$pdf->output('I', 'factura.pdf');
?>
