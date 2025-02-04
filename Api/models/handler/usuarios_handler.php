<?php
// Se incluye la clase para trabajar con la base de datos.
require_once ('../../helpers/database.php');

//Esta clase es para manejar el comportamiento de los datos de la tabla Usuarios

class UsuariosHandler
{
    //Declaracion de atributos para el manejo de los datos de la tabla en la base de datos
    protected $idUsuario = null;
    protected $nombreUsuario = null;
    protected $claveUsuario = null;
    protected $correoUsuario = null;

    /*Metodos para administrar las cuentas de Usuarios*/

    
    //Esta funcion valida las credenciales en el inicio de sesion
    public function checkUser($username, $password)
    {
        $sql = 'SELECT id_usuario, nombre_usuario, correo, clave
                FROM usuarios
                WHERE  correo = ?';
        $params = array($username);
        if (!($data = Database::getRow($sql, $params))) {
            return false;
        } elseif (password_verify($password, $data['clave'])) {
            $_SESSION['idAdministrador'] = $data['id_usuario'];
            $_SESSION['aliasAdmin'] = $data['correo'];
            $_SESSION['nombreAdministrador'] = $data['nombre_usuario'];
            return true;
        } else {
            return false;
        }
    }

    //Esta funcion valida que la contraseña del usuario coincida con la de la base de datos
    public function checkPassword($password)    
    {
        $sql = 'SELECT clave
                FROM usuarios
                WHERE id_usuario = ?';
        $params = array($_SESSION['idAdministrador']);
        $data = Database::getRow($sql, $params);
        // Se verifica si la contraseña coincide con el hash almacenado en la base de datos.
        if (password_verify($password, $data['clave'])) {
            return true;
        } else {
            return false;
        }
    }

    //Esta funcion es para cambiar solamente la contraseña
    public function changePassword()
    {
        $sql = 'UPDATE usuarios
                SET clave = ?
                WHERE id_usuario = ?';
        $params = array($this->claveUsuario, $_SESSION['idAdministrador']);
        return Database::executeRow($sql, $params);
    }

    //Esta funcion muestra los datos del usuario
    public function readProfile()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, correo, clave
                FROM usuarios
                WHERE id_usuario = ?';
        $params = array($_SESSION['idAdministrador']);
        return Database::getRow($sql, $params);
    }

    //Esta funcion edita los datos del usuario
    public function editProfile()
    {
        $sql = 'UPDATE usuarios
                SET nombre_usuario = ?, correo = ?, clave = ?
                WHERE id_usuario = ?';
        $params = array($this->nombreUsuario, $this->correoUsuario, $this->claveUsuario, $_SESSION['idAdministrador']);
        return Database::executeRow($sql, $params);
    }


    //Esta funcion verifica los datos duplicados
    public function checkDuplicate($value)
    {
        $sql = 'SELECT id_usuario
                FROM usuarios
                WHERE id_usuario = ? OR correo = ?';
        $params = array($value, $value);
        return Database::getRow($sql, $params);
    }

    /*Metodos para realizar las operaciones SCRUD*/

    //Search
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_usuario, nombre_usuario, correo
                FROM usuarios
                WHERE nombre_usuario LIKE ? OR id_usuario LIKE ?
                ORDER BY nombre_usuario';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }

    //Create
    public function createRow()
    {
        $sql = 'INSERT INTO usuarios (nombre_usuario, clave, correo)
                VALUES(?, ?, ?)';
        $params = array($this->nombreUsuario, $this->claveUsuario, $this->correoUsuario);
        return Database::executeRow($sql, $params);
    }

    //ReadAll
    public function readAll()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, correo
                FROM usuarios
                ORDER BY nombre_usuario';
        return Database::getRows($sql);
    }

    //ReadOne
    public function readOne()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, correo
                FROM usuarios
                WHERE id_usuario = ?';
        $params = array($this->idUsuario);
        return Database::getRow($sql, $params);
    }

    //Update
    public function updateRow()
    {
        $sql = 'UPDATE usuarios
                SET nombre_usuario = ?,
                clave = ?, 
                correo = ?
                WHERE id_usuario = ?';
        $params = array($this->nombreUsuario, $this->claveUsuario, $this->correoUsuario, $this->idUsuario);
        return Database::executeRow($sql, $params);
    }

    //Delete
    public function deleteRow()
    {
        $sql = 'DELETE FROM usuarios
                WHERE id_usuario = ?';
        $params = array($this->idUsuario);
        return Database::executeRow($sql, $params);
    }

    

}