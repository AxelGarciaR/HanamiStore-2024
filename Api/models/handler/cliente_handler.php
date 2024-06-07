<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
*	Clase para manejar el comportamiento de los datos de la tabla CLIENTE.
*/
class ClienteHandler
{
    /*
    *   Declaración de atributos para el manejo de datos.
    */
    protected $idCliente = null;
    protected $nombreCliente = null;
    protected $apellidoCliente = null;
    protected $nombrePerfil = null;
    protected $clave = null;
    protected $correoE = null;
    protected $direccion = null;
    protected $estado = null;

    /*
    *   Métodos para gestionar la cuenta del cliente.
    */
    public function checkUser($mail, $password)
    {
        $sql = 'SELECT id_cliente, CorreoE, clave, estado
                FROM clientes
                WHERE CorreoE = ?';
        $params = array($mail);
        $data = Database::getRow($sql, $params);
        if (password_verify($password, $data['clave'])) {
            $this->idCliente = $data['id_cliente'];
            $this->correoE = $data['CorreoE'];
            $this->estado = $data['estado'];
            return true;
        } else {
            return false;
        }
    }

    public function checkStatus()
    {
        if ($this->estado) {
            $_SESSION['idCliente'] = $this->idCliente;
            $_SESSION['correoCliente'] = $this->correoE;
            return true;
        } else {
            return false;
        }
    }

    public function changePassword()
    {
        $sql = 'UPDATE clientes
                SET clave = ?
                WHERE id_cliente = ?';
        $params = array($this->clave, $this->idCliente);
        return Database::executeRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE clientes
        SET nombre_cliente = ?, apellido_cliente = ?, nombre_perfil = ?, clave = ?, CorreoE = ?, Direccion  = ?
        WHERE id_cliente = ?';
        $params = array($this->nombreCliente, $this->apellidoCliente, $this->nombrePerfil, $this->clave, $this->correoE, $this->direccion, $this->idCliente);
        return Database::executeRow($sql, $params);
    }

    public function changeStatus()
    {
        $sql = 'UPDATE clientes 
                SET estado = ?
                WHERE id_cliente = ?';
        $params = array($this->estado, $this->idCliente);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
    */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_cliente, nombre_cliente, apellido_cliente, nombre_perfil , clave , CorreoE, Direccion
                FROM clientes
                WHERE apellido_cliente LIKE ? OR nombre_cliente LIKE ? OR CorreoE LIKE ?
                ORDER BY apellido_cliente';
        $params = array($value, $value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO clientes(nombre_cliente, apellido_cliente, nombre_perfil, clave, CorreoE, Direccion)
                VALUES(?, ?, ?, ?, ?, ?)';
        $params = array($this->nombreCliente, $this->apellidoCliente, $this->nombrePerfil, $this->clave, $this->correoE, $this->direccion);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_cliente, nombre_cliente, apellido_cliente, nombre_perfil, CorreoE, Direccion, estado
                FROM clientes
                ORDER BY apellido_cliente';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_cliente, nombre_cliente, apellido_cliente, nombre_perfil, clave, CorreoE, Direccion, estado
                FROM clientes 
                WHERE id_cliente = ?';
        $params = array($this->idCliente);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE clientes
                SET nombre_cliente = ?, apellido_cliente = ?, nombre_perfil = ?, clave = ?, CorreoE = ?, Direccion  = ?, estado = ?
                WHERE id_cliente = ?';
        $params = array($this->nombreCliente, $this->apellidoCliente, $this->nombrePerfil, $this->clave, $this->correoE, $this->direccion, $this->estado, $this->idCliente);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM clientes
                WHERE id_cliente = ?';
        $params = array($this->idCliente);
        return Database::executeRow($sql, $params);
    }

    public function checkDuplicate($value)
    {
        $sql = 'SELECT id_cliente
                FROM clientes
                WHERE CorreoE  = ?';
        $params = array($value, $value);
        return Database::getRow($sql, $params);
    }
}
