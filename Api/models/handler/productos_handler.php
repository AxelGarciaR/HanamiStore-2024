<?php
// Se incluye la clase para trabajar con la base de datos.
require_once ('../../helpers/database.php');
 
//Esta clase es para manejar el comportamiento de los datos de la tabla Usuarios
 
class ProductosHandler
{
    //Declaracion de atributos para el manejo de los datos de la tabla en la base de datos
    protected $idProducto = null;
    protected $nombreProducto = null;
    protected $descripcionProducto = null;
    protected $precioProducto = null;
    protected $imagenPrincipal = null;
    protected $cantidadProducto = null;
    protected $idSubcategoria = null;
    protected $descuento = null;
    protected $marca = null;
 
    // Constante para establecer la ruta de las imagenes
    const RUTA_IMAGEN = '../../images/productos/';
 
    //Aqui empiesan las funciones SCRUD
 
    //Esta funcion es para buscar productos
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_Producto, Nombre_Producto, descripcion_producto, precio_producto, imagen_principal, CantidadP, id_subcategoria, descuento, id_Marca
                FROM productos
                WHERE Nombre_Producto LIKE ? OR id_Producto LIKE ?';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }
 
    //Esta funcion es para crear productos
    public function createRow()
    {
        $sql = 'INSERT INTO productos (Nombre_Producto, descripcion_producto, precio_producto, imagen_principal, CantidadP, id_subcategoria, descuento, id_Marca)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombreProducto, $this->descripcionProducto, $this->precioProducto, $this->imagenPrincipal, $this->cantidadProducto, $this->idSubcategoria, $this->descuento, $this->marca);
        return Database::executeRow($sql, $params);
    }
 
    //Esta funcion es para leer todos los productos
    public function readAll()
    {
        $sql = 'SELECT id_Producto , Nombre_Producto , descripcion_producto , precio_producto , imagen_principal , CantidadP, id_subcategoria ,descuento, id_Marca
                FROM productos
                ORDER BY Nombre_Producto';
        return Database::getRows($sql);
    }
 
    public function cantidadProductosCategoria()
    {
        $sql = 'SELECT nombre, COUNT(id_producto) CantidadP
                FROM productos
                INNER JOIN sub_categorias USING(id_SubCategoria)
                GROUP BY nombre ORDER BY CantidadP DESC LIMIT 5';
        return Database::getRows($sql);
    }
 
    public function porcentajeProductosCategoria()
    {
        $sql = 'SELECT nombre, ROUND((COUNT(id_producto) * 100.0 / (SELECT COUNT(id_producto) FROM productos)), 2) porcentaje
                FROM productos
                INNER JOIN sub_categorias USING(id_SubCategoria)
                GROUP BY nombre ORDER BY porcentaje DESC';
        return Database::getRows($sql);
    }
 
    public function productosMasVendidos()
    {
        $sql = 'SELECT Nombre_Producto, SUM(cantidad) AS total_vendido
            FROM detalleordenes
            INNER JOIN productos ON detalleordenes.id_producto = productos.id_producto
            GROUP BY Nombre_Producto
            ORDER BY total_vendido DESC
            LIMIT 5';  // Agrega LIMIT 5 para obtener solo los 5 productos más vendidos
        return Database::getRows($sql);
    }
 
 
 
 
    //Esta funcion es para hacer select de los productos de mayor id a menor para ver cuales son los mas nuevos
    public function NewProduct()
    {
        $sql = 'SELECT id_Producto, Nombre_Producto, descripcion_producto, precio_producto, imagen_principal, CantidadP, id_subcategoria, descuento, id_Marca
                FROM productos
                ORDER BY id_Producto DESC
                LIMIT 10';
        return Database::getRows($sql);
    }
 
    //Esta funcion es para leer un producto en especifico
    public function readOne()
    {
        $sql = 'SELECT id_Producto, Nombre_Producto, descripcion_producto, precio_producto, imagen_principal, CantidadP, id_subcategoria, descuento, id_Marca
                FROM productos
                WHERE id_Producto = ?';
        $params = array($this->idProducto);
        return Database::getRow($sql, $params);
    }
 
    public function ventasPorMes()
    {
        $sql = 'SELECT DATE_FORMAT(m.fecha, \'%M\') AS mes, COALESCE(SUM(dp.cantidad), 0) AS cantidad_ventas
            FROM (
            SELECT DATE_ADD(\'2023-01-01\', INTERVAL (a.n + 10 * b.n) MONTH) AS fecha
            FROM (
            SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL
            SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9
            ) AS a
            CROSS JOIN (
                            SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL
                            SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9
                        ) AS b
                    ) AS m
                    LEFT JOIN ordenes p ON MONTH(p.Fecha_Orden) = MONTH(m.fecha) AND YEAR(p.Fecha_Orden) = YEAR(m.fecha)
                    LEFT JOIN detalleordenes dp ON p.id_Orden = dp.id_Orden
                    GROUP BY DATE_FORMAT(m.fecha, \'%M\')
                    ORDER BY MONTH(m.fecha)';
       
            return Database::getRows($sql);
        }
 
 
    //Esta funcion es para actualizar un producto
    public function updateRow()
    {
        $sql = 'UPDATE productos
                SET Nombre_Producto = ?,
                descripcion_producto = ?,
                precio_producto = ?,
                imagen_principal = ?,
                CantidadP = ?,
                id_subcategoria = ?,
                descuento = ?,
                id_Marca = ?
                WHERE id_Producto = ?';
        $params = array($this->nombreProducto, $this->descripcionProducto, $this->precioProducto, $this->imagenPrincipal, $this->cantidadProducto, $this->idSubcategoria, $this->descuento, $this->marca, $this->idProducto);
        return Database::executeRow($sql, $params);
    }
 
    //Esta funcion es para eliminar un producto
    public function deleteRow()
    {
        $sql = 'DELETE FROM productos
                WHERE id_Producto = ?';
        $params = array($this->idProducto);
        return Database::executeRow($sql, $params);
    }
 
    // funcion para ver la imagen en la tabla del producto correspondiente
    public function readFilename()
    {
        $sql = 'SELECT imagen_principal
                FROM productos
                WHERE id_Producto = ?';
        $params = array($this->idProducto);
        return Database::getRow($sql, $params);
    }

    public function readByMarca() {
        $sql = 'SELECT p.Nombre_Producto, p.precio_producto, p.CantidadP, s.nombre AS nombre_subcategoria
                FROM productos p
                JOIN sub_categorias s ON p.id_subcategoria = s.id_SubCategoria
                WHERE p.id_Marca = ?';
        $params = array($this->marca);
        return Database::getRows($sql, $params);
    }
 
}
