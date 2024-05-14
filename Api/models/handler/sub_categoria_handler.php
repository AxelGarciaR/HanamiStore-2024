<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla CATEGORIA.
 */
class SubCategoriaHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $id = null;
    protected $nombreSubCategoria = null;
    protected $idCategoria = null;


    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_SubCategoria , nombre, id_Categoria 
                FROM sub_categorias 
                WHERE nombre LIKE ? OR id_SubCategoria LIKE ?
                ORDER BY nombre';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO sub_categorias(nombre, id_Categoria)
                VALUES(?, ?)';
        $params = array($this->nombreSubCategoria, $this->idCategoria);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_SubCategoria , nombre, id_Categoria  
                FROM sub_categorias 
                ORDER BY nombre';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_SubCategoria , nombre, id_Categoria
                FROM sub_categorias 
                WHERE id_SubCategoria = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE sub_categorias 
                SET nombre  = ?, id_Categoria = ?
                WHERE id_Categoria = ?';
        $params = array($this->nombreSubCategoria);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM sub_categorias 
                WHERE id_SubCategoria  = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
