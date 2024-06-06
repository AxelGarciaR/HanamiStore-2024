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
    protected $id = null; // Identificador de la categoría.
    protected $nombreCategoria = null; // Nombre de la categoría.

    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */

    // Método para buscar categorías que coincidan con un valor de búsqueda.
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%'; // Valor de búsqueda.
        $sql = 'SELECT id_Categoria, Nombre_Categoria
                FROM categorias
                WHERE Nombre_Categoria LIKE ? OR id_Categoria LIKE ?
                ORDER BY Nombre_Categoria'; // Consulta SQL para buscar categorías.
        $params = array($value, $value); // Parámetros para la consulta.
        return Database::getRows($sql, $params); // Ejecuta la consulta y devuelve los resultados.
    }

    // Método para crear una nueva categoría en la base de datos.
    public function createRow()
    {
        $sql = 'INSERT INTO categorias(Nombre_Categoria)
                VALUES(?)'; // Consulta SQL para insertar una nueva categoría.
        $params = array($this->nombreCategoria); // Parámetros para la consulta.
        return Database::executeRow($sql, $params); // Ejecuta la consulta y devuelve el resultado.
    }

    // Método para leer todas las categorías de la base de datos.
    public function readAll()
    {
        $sql = 'SELECT id_Categoria, Nombre_Categoria
                FROM categorias
                ORDER BY Nombre_Categoria'; // Consulta SQL para seleccionar todas las categorías.
        return Database::getRows($sql); // Ejecuta la consulta y devuelve los resultados.
    }

    // Método para leer una categoría específica de la base de datos.
    public function readOne()
    {
        $sql = 'SELECT id_Categoria, Nombre_Categoria
                FROM categorias
                WHERE id_Categoria = ?'; // Consulta SQL para seleccionar una categoría por su ID.
        $params = array($this->id); // Parámetros para la consulta.
        return Database::getRow($sql, $params); // Ejecuta la consulta y devuelve el resultado.
    }

    // Método para actualizar una categoría en la base de datos.
    public function updateRow()
    {
        $sql = 'UPDATE categorias
                SET Nombre_Categoria = ?
                WHERE id_Categoria = ?'; // Consulta SQL para actualizar una categoría.
        $params = array($this->nombreCategoria, $this->id); // Parámetros para la consulta.
        return Database::executeRow($sql, $params); // Ejecuta la consulta y devuelve el resultado.
    }

    // Método para eliminar una categoría de la base de datos.
    public function deleteRow()
    {
        $sql = 'DELETE FROM categorias
                WHERE id_Categoria = ?'; // Consulta SQL para eliminar una categoría.
        $params = array($this->id); // Parámetros para la consulta.
        return Database::executeRow($sql, $params); // Ejecuta la consulta y devuelve el resultado.
    }

    // Método para obtener las últimas categorías creadas.
    public function newCategoria()
    {
        $sql = 'SELECT id_Categoria, Nombre_Categoria
                FROM categorias
                ORDER BY id_Categoria'; 
        return Database::getRows($sql); // Ejecuta la consulta y devuelve los resultados.
    }
}
?>
