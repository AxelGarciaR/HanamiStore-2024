<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../models/data/categoria_data.php');

// Función para obtener el nombre del administrador
function getAdminName($adminId)
{
    $db = new Database;
    $sql = 'SELECT nombre_usuario FROM usuarios WHERE id_usuario = ?';
    $params = array($adminId);
    if ($data = $db->getRow($sql, $params)) {
        return $data['nombre_usuario'];
    } else {
        return 'Desconocido'; // Devuelve 'Desconocido' si no se encuentra el nombre
    }
}

// Suponiendo que tienes el ID del administrador en sesión
$adminId = 1; // Ejemplo, debes obtener el ID del administrador en sesión de tu lógica de autenticación

// Obtener el nombre del administrador en sesión
$adminName = getAdminName($adminId);

// Se instancia la clase para crear el reporte.
$pdf = new Report;

// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Reporte de categorías y productos registrados - Generado por: ' . $adminName);

// Se instancia el modelo de categorías para obtener los datos.
$categoria = new CategoriaData;

// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataCategoria = $categoria->readAllReport()) {
    // Ancho total de la tabla (ajústalo según necesites)
    $anchoTotal = 140; // Reduje el ancho total para alinear mejor los datos según la estructura mostrada

    // Calcula la posición x inicial para centrar la tabla
    $posXInicial = ($pdf->GetPageWidth() - $anchoTotal) / 2;

    // Variables para controlar la categoría actual
    $currentCategory = null;

    // Recorre los registros fila por fila.
    foreach ($dataCategoria as $rowCategoria) {
        // Verifica si la categoría ha cambiado para imprimir el nombre de la nueva categoría
        if ($currentCategory !== $rowCategoria['Nombre_Categoria']) {
            $currentCategory = $rowCategoria['Nombre_Categoria'];

            // Deja un espacio antes de imprimir una nueva categoría
            $pdf->Ln(5);

            // Imprime una celda que abarque toda la tabla con el nombre de la categoría
            $pdf->SetX($posXInicial);
            $pdf->setFillColor(255, 200, 221); // Color FFC8DD en RGB
            $pdf->setFont('Arial', 'B', 12);
            $pdf->cell($anchoTotal, 10, $pdf->encodeString('Categoría: ' . $currentCategory), 1, 1, 'C', 1);

            // Imprime los encabezados de los productos
            $pdf->SetX($posXInicial);
            $pdf->setFont('Arial', 'B', 11);
            $pdf->cell(30, 10, 'ID Producto', 1, 0, 'C', 1);
            $pdf->cell(50, 10, 'Nombre Producto', 1, 0, 'C', 1);
            $pdf->cell(30, 10, 'Precio', 1, 0, 'C', 1);
            $pdf->cell(30, 10, 'Cantidad', 1, 1, 'C', 1);
        }

        // Se establece la fuente para los datos de los productos.
        $pdf->setFont('Arial', '', 11);

        // Establece un color de relleno alternante para las filas de datos.
        $pdf->setFillColor(255, 240, 245); // Color más claro

        // Imprime las celdas con los datos de los productos.
        $pdf->SetX($posXInicial);
        $pdf->cell(30, 10, $rowCategoria['id_Producto'], 1, 0, '', 1);
        $pdf->cell(50, 10, $pdf->encodeString($rowCategoria['Nombre_Producto']), 1, 0, '', 1);
        $pdf->cell(30, 10, $rowCategoria['precio_producto'], 1, 0, '', 1);
        $pdf->cell(30, 10, $rowCategoria['CantidadP'], 1, 1, '', 1);
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay productos para mostrar'), 1, 1);
}

// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'Categorias_y_Productos.pdf');
?>
