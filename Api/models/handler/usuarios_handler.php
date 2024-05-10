<?php
// Se incluye la clase para trabajar con la base de datos.
require_once ('../../helpers/database.php');

//Esta clase es para manejar el comportamiento de los datos de la tabla Usuarios

class UsuariosHandler
{

    protected $id = null;
    protected $nombre = null;
    protected $clave = null;
    protected $correo = null;
    protected $imagen = null;

    // Constante para establecer la ruta de las imagenes
    const RUTA_IMAGEN = '../../images/productos/';

    /*Metodos para administrar las cuentas de Usuarios*/

    public function checkUser($username, $password)
    {
        $sql = 'SELECT id_usuario, nombre_usuario, clave
                FROM usuarios
                WHERE  nombre_usuario = ?';
        $params = array($username);
        if (!($data = Database::getRow($sql, $params))) {
            return false;
        } elseif (password_verify($password, $data['clave'])) {
            $_SESSION['idAdministrador'] = $data['id_usuario'];
            $_SESSION['aliasAdministrador'] = $data['nombre_usuario'];
            return true;
        } else {
            return false;
        }
    }

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

    public function changePassword()
    {
        $sql = 'UPDATE usuarios
                SET clave = ?
                WHERE id_usuario = ?';
        $params = array($this->clave, $_SESSION['idadministrador']);
        return Database::executeRow($sql, $params);
    }

    public function readProfile()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, correo
                FROM usuarios
                WHERE id_usuario = ?';
        $params = array($_SESSION['idAdministrador']);
        return Database::getRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE usuarios
                SET nombre_usuario = ?, correo = ?,
                imagen = ?
                WHERE id_usuario = ?';
        $params = array($this->nombre, $this->correo, $this->imagen, $_SESSION['idAdministrador']);
        return Database::executeRow($sql, $params);
    }

    /*Metodos para realizar las operaciones SCRUD*/

    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_usuario, nombre_usuario, id_tipousuario, imagen
                FROM usuarios
                WHERE nombre_usuario LIKE ? OR id_usuario LIKE ?
                ORDER BY nombre_usuario';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO usuarios (nombre_usuario, clave, correo, imagen)
                VALUES(?, ?, ?, ?)';
        $params = array($this->nombre, $this->clave, $this->correo, $this->imagen);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, correo, imagen
                FROM usuarios
                ORDER BY nombre_usuario';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, correo, imagen,
                FROM usuarios
                WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function readFilename()
    {
        $sql = 'SELECT imagen
                FROM usuarios
                WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE usuarios
                SET nombre_usuario = ?,
                clave = ?, 
                correo = ?,
                imagen = ?
                WHERE id_usuario = ?';
        $params = array($this->nombre, $this->clave, $this->correo, $this->imagen);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM usuarios
                WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function checkDuplicate($value)
    {
        $sql = 'SELECT id_usuario
                FROM usuarios
                WHERE id_usuario = ? OR correo = ?';
        $params = array($value, $value);
        return Database::getRow($sql, $params);
    }

}