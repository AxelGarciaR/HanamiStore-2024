<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');

//Esta clase es para manejar el comportamiento de los datos de la tabla Usuarios

class ProductosHandler
{
    //Declaracion de atributos para el manejo de los datos de la tabla en la base de datos
    protected $id = null;
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
                WHERE Nombre_Producto LIKE ? OR id_Producto LIKE ?
                ORDER BY Nombre_Producto';
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
        $params = array($this->id);
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
        $params = array($this->nombreProducto, $this->descripcionProducto, $this->precioProducto, $this->imagenPrincipal, $this->cantidadProducto, $this->idSubcategoria,$this->descuento, $this->marca);
        return Database::executeRow($sql, $params);
    }

    //Esta funcion es para eliminar un producto
    public function deleteRow()
    {
        $sql = 'DELETE FROM productos
                WHERE id_Producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    // funcion para ver la imagen en la tabla del producto correspondiente
    public function readFilename()
    {
        $sql = 'SELECT imagen_principal
                FROM productos
                WHERE id_Producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

}
<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');

// Clase para manejar el comportamiento de los datos de la tabla Marcas
class MarcasHandler
{
    // Declaración de atributos para el manejo de los datos de la tabla en la base de datos
    protected $idMarca = null;
    protected $nombreMarca = null;
    protected $logoMarca = null;

    // Constante para establecer la ruta de las imágenes
    const RUTA_IMAGEN = '../../images/marcas/';

    // Aquí empiezan las funciones SCRUD

    // Función para buscar marcas
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_Marca, Nombre_Marca, Logo_Marca
                FROM Marcas
                WHERE Nombre_Marca LIKE ? OR id_Marca LIKE ?
                ORDER BY Nombre_Marca';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }

    // Función para crear una nueva marca
    public function createRow()
    {
        $sql = 'INSERT INTO Marcas (Nombre_Marca, Logo_Marca)
                VALUES(?, ?)';
        $params = array($this->nombreMarca, $this->logoMarca);
        return Database::executeRow($sql, $params);
    }

    // Función para leer todas las marcas
    public function readAll()
    {
        $sql = 'SELECT id_Marca, Nombre_Marca, Logo_Marca
                FROM Marcas
                ORDER BY Nombre_Marca';
        return Database::getRows($sql);
    }

    // Función para leer una marca específica
    public function readOne()
    {
        $sql = 'SELECT id_Marca, Nombre_Marca, Logo_Marca
                FROM Marcas
                WHERE id_Marca = ?';
        $params = array($this->idMarca);
        return Database::getRow($sql, $params);
    }

    // Función para actualizar una marca
    public function updateRow()
    {
        $sql = 'UPDATE Marcas
                SET Nombre_Marca = ?,
                Logo_Marca = ?
                WHERE id_Marca = ?';
        $params = array($this->nombreMarca, $this->logoMarca, $this->idMarca);
        return Database::executeRow($sql, $params);
    }

    // Función para eliminar una marca
    public function deleteRow()
    {
        $sql = 'DELETE FROM Marcas
                WHERE id_Marca = ?';
        $params = array($this->idMarca);
        return Database::executeRow($sql, $params);
    }

    // Función para obtener el nombre del archivo de la marca
    public function readFilename()
    {
        $sql = 'SELECT Logo_Marca
                FROM Marcas
                WHERE id_Marca = ?';
        $params = array($this->idMarca);
        return Database::getRow($sql, $params);
    }
}
