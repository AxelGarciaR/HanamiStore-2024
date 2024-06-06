<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla CATEGORIA.
 */
class CategoriaHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $id = null;
    protected $nombreCategoria = null;


    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_Categoria, Nombre_Categoria
                FROM categorias
                WHERE Nombre_Categoria LIKE ? OR id_Categoria LIKE ?
                ORDER BY Nombre_Categoria';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
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
}
