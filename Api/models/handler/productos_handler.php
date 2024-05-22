<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');

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
                VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombreProducto, $this->descripcionProducto, $this->precioProducto, $this->imagenPrincipal, $this->cantidadProducto, $this->idSubcategoria,$this->descuento, $this->marca);
        return Database::executeRow($sql, $params);
    }

    //Esta funcion es para leer todos los productos
    public function readAll()
    {
        $sql = 'SELECT id_Producto, Nombre_Producto, descripcion_producto, precio_producto, imagen_principal, CantidadP, id_subcategoria,descuento, id_Marca
                FROM productos
                ORDER BY Nombre_Producto';
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
        $params = array($this->nombreProducto, $this->descripcionProducto, $this->precioProducto, $this->imagenPrincipal, $this->cantidadProducto, $this->idSubcategoria,$this->descuento, $this->marca, $this->idProducto);
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

}
