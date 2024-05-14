<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');

//Esta clase es para manejar el comportamiento de los datos de la tabla Usuarios

class ValoracionesHandler
{
    //Declaracion de atributos para el manejo de los datos de la tabla en la base de datos
    protected $id = null;
    protected $valoracion = null;
    protected $idDetalle = null;
    protected $comentario  = null;
    protected $fechaComentario = null;
    protected $estadoComentario = null;

    //Aqui empiesan las funciones SCRUD

    //Esta funcion es para buscar productos
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_valoracion, Valoracion, id_detalle, comentario, fecha_comentario, estado_comentario
                FROM valoraciones 
                WHERE id_valoracion  LIKE ? OR id_detalle  LIKE ?';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }

    //Esta funcion es para crear productos
    public function createRow()
    {
        $sql = 'INSERT INTO valoraciones(Valoracion , id_detalle , comentario , fecha_comentario , estado_comentario)
                VALUES(?, ?, ?, ?, ?)';
        $params = array($this->valoracion, $this->idDetalle, $this->comentario, $this->fechaComentario, $this->estadoComentario);
        return Database::executeRow($sql, $params);
    }

    //Esta funcion es para leer todos los productos
    public function readAll()
    {
        $sql = 'SELECT id_valoracion , Valoracion , id_detalle , comentario , fecha_comentario , estado_comentario
                FROM valoraciones';
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
        $sql = 'UPDATE valoraciones
                SET Valoracion  = ?,
                id_detalle  = ?, 
                comentario  = ?,
                fecha_comentario  = ?,
                estado_comentario  = ?
                WHERE id_valoracion  = ?';
        $params = array($this->valoracion, $this->idDetalle, $this->comentario, $this->fechaComentario, $this->estadoComentario);
        return Database::executeRow($sql, $params);
    }

    //Esta funcion es para eliminar un producto
    public function deleteRow()
    {
        $sql = 'DELETE FROM valoraciones 
                WHERE id_valoracion  = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}