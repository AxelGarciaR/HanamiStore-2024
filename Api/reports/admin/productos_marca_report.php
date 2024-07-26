<?php
require_once('../../helpers/report.php');
require_once('../../models/data/productos_data.php');
require_once('../../models/data/marcas_data.php');

$pdf = new Report;
$pdf->startReport('Productos por marca');

$marca = new MarcasData;

if ($dataMarca = $marca->readAll()) {
    $anchoTotal = 180;
    $posXInicial = ($pdf->GetPageWidth() - $anchoTotal) / 2;

    $pdf->setFillColor(255, 200, 221); // Color para encabezados
    $pdf->setFont('Arial', 'B', 11);

    $pdf->SetX($posXInicial);
    $pdf->cell(51, 10, 'Nombre producto', 1, 0, 'C', 1);
    $pdf->cell(45, 10, 'Precio (US$)', 1, 0, 'C', 1);
    $pdf->cell(45, 10, 'Existencias', 1, 0, 'C', 1);
    $pdf->cell(45, 10, 'Subcategoria', 1, 1, 'C', 1);

    $pdf->setFont('Arial', '', 11);

    foreach ($dataMarca as $rowMarca) {
        $pdf->SetX($posXInicial);
        $pdf->setFillColor(255, 240, 245); // Color más claro
        $pdf->cell(186, 10, $pdf->encodeString('Marca: ' . $rowMarca['Nombre_Marca']), 1, 1, 'C', 1);

        $producto = new ProductosData;
        if ($producto->setIdMarca($rowMarca['id_Marca'])) {
            if ($dataProductos = $producto->readByMarca()) {
                foreach ($dataProductos as $rowProducto) {
                    $pdf->setFillColor(255, 245, 250); // Color más claro para filas
                    $pdf->SetX($posXInicial);
                    $pdf->cell(51, 10, $pdf->encodeString($rowProducto['Nombre_Producto']), 1, 0, '', 1);
                    $pdf->cell(45, 10, '$' . number_format($rowProducto['precio_producto'], 2), 1, 0, 'C', 1);
                    $pdf->cell(45, 10, $rowProducto['CantidadP'], 1, 0, 'C', 1);
                    $pdf->cell(45, 10, $pdf->encodeString($rowProducto['nombre_subcategoria']), 1, 1, '', 1);
                }
            } else {
                $pdf->SetX($posXInicial);
                $pdf->setFillColor(255, 245, 250); // Color más claro
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para la marca'), 1, 1, 'C', 1);
            }
        } else {
            $pdf->SetX($posXInicial);
            $pdf->setFillColor(255, 245, 250); // Color más claro
            $pdf->cell(0, 10, $pdf->encodeString('Marca incorrecta o inexistente'), 1, 1, 'C', 1);
        }
    }
} else {
    $pdf->SetX($posXInicial);
    $pdf->setFillColor(255, 245, 250); // Color más claro
    $pdf->cell(0, 10, $pdf->encodeString('No hay marcas para mostrar'), 1, 1, 'C', 1);
}

$pdf->output('I', 'productos.pdf');
?>
