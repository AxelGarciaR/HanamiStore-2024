<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla CATEGORIA.
 */
class ClientePrivHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $idCliente = null;

    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_cliente , nombre_cliente, apellido_cliente, nombre_perfil, CorreoE, Direccion 
                FROM clientes
                WHERE nombre_cliente LIKE ? OR id_cliente LIKE ?
                ORDER BY nombre_cliente';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }


    public function readAll()
    {
        $sql = 'SELECT id_cliente , nombre_cliente, apellido_cliente, nombre_perfil, CorreoE, Direccion 
                FROM clientes
                ORDER BY nombre_cliente';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_cliente , nombre_cliente, apellido_cliente, nombre_perfil, CorreoE, Direccion
                FROM clientes
                WHERE id_cliente  = ?';
        $params = array($this->idCliente);
        return Database::getRow($sql, $params);
    }
}
