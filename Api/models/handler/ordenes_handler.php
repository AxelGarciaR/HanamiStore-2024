<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla CATEGORIA.
 */
class OrdenesHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $idOrden = null;
    protected $idCliente = null;
    protected $fechaOrden = null;
    protected $estadoOrden = null;


    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_Orden, id_Cliente, Fecha_Orden, Estado_Orden 
                FROM ordenes
                WHERE id_Orden LIKE ? OR id_Cliente LIKE ?';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO ordenes(id_Cliente, Fecha_Orden, Estado_Orden)
                VALUES(?, ?, ?)';
        $params = array($this->idCliente, $this->fechaOrden, $this->estadoOrden);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_Orden, id_Cliente, Fecha_Orden, Estado_Orden
                FROM ordenes
                ORDER BY id_Orden';
        return Database::getRows($sql);
    }

    public function readOrdenesReport()
    {
        $sql = 'SELECT 
        o.id_Orden, 
        o.id_Cliente, 
        o.Fecha_Orden, 
        o.Estado_Orden,
        c.nombre_cliente,
        c.apellido_cliente,
        c.CorreoE
        FROM 
        ordenes o
        JOIN 
        clientes c ON o.id_Cliente = c.id_cliente
        ORDER BY 
        o.Estado_Orden;';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_Orden, id_Cliente, Fecha_Orden, Estado_Orden
                FROM ordenes
                WHERE id_Orden = ?';
        $params = array($this->idOrden);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE ordenes
                SET id_Cliente = ?,
                Fecha_Orden = ?,
                Estado_Orden = ? 
                WHERE id_Orden = ?';
        $params = array($this->idCliente, $this->fechaOrden, $this->estadoOrden, $this->idOrden);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM ordenes 
                WHERE id_Orden = ?';
        $params = array($this->idOrden);
        return Database::executeRow($sql, $params);
    }
}
