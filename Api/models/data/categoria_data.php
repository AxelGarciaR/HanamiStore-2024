<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/categoria_handler.php');
/*
 *  Clase para manejar el encapsulamiento de los datos de la tabla CATEGORIA.
 */
class CategoriaData extends CategoriaHandler
{
    /*
     *  Atributos adicionales.
     */
    private $data_error = null;

    /*
     *  Métodos para validar y establecer los datos.
     */
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            $this->data_error = 'El identificador de la categoría es incorrecto';
            return false;
        }
    }

    public function setNombreCategoria($value, $min = 2, $max = 50)
    {
        if (!Validator::validateAlphanumeric($value)) {
            $this->data_error = 'El nombre debe ser un valor alfanumérico';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->nombreCategoria = $value;
            return true;
        } else {
            $this->data_error = 'El nombre debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    public function createRow()
    {
        $sql = 'INSERT INTO categorias(Nombre_Categoria)
                VALUES(?)';
        $params = array($this->nombreCategoria);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_Categoria, Nombre_Categoria
                FROM categorias
                ORDER BY Nombre_Categoria';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_Categoria, Nombre_Categoria
                FROM categorias
                WHERE id_Categoria = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE categorias
                SET Nombre_Categoria = ?
                WHERE id_Categoria = ?';
        $params = array($this->nombreCategoria, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM categorias
                WHERE id_Categoria = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function newCategoria()
    {
        $sql = 'SELECT id_Categoria, Nombre_Categoria
                FROM categorias
                ORDER BY id_Categoria DESC
                LIMIT 10';
        return Database::getRows($sql);
    }

    /*
     *  Métodos para obtener los atributos adicionales.
     */
    public function getDataError()
    {
        return $this->data_error;
    }
}
