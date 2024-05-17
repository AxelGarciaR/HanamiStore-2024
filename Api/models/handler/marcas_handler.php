<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');

// Clase para manejar el comportamiento de los datos de la tabla Marcas
class MarcasHandler
{
    // Declaración de atributos para el manejo de los datos de la tabla en la base de datos
    protected $idMarca = null;
    protected $nombreMarca = null;
    protected $logoMarca = null;

    // Constante para establecer la ruta de las imágenes
    const RUTA_IMAGEN = '../../images/marcas/';

    // Aquí empiezan las funciones SCRUD

    // Función para buscar marcas
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_Marca, Nombre_Marca
                FROM Marcas
                WHERE Nombre_Marca LIKE ? OR id_Marca LIKE ?
                ORDER BY Nombre_Marca';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }

    // Función para crear una nueva marca
    public function createRow()
    {
        $sql = 'INSERT INTO Marcas (Nombre_Marca)
                VALUES(?)';
        $params = array($this->nombreMarca);
        return Database::executeRow($sql, $params);
    }

    // Función para leer todas las marcas
    public function readAll()
    {
        $sql = 'SELECT id_Marca, Nombre_Marca
                FROM Marcas
                ORDER BY Nombre_Marca';
        return Database::getRows($sql);
    }

    // Función para leer una marca específica
    public function readOne()
    {
        $sql = 'SELECT id_Marca, Nombre_Marca
                FROM Marcas
                WHERE id_Marca = ?';
        $params = array($this->idMarca);
        return Database::getRow($sql, $params);
    }

    // Función para actualizar una marca
    public function updateRow()
    {
        $sql = 'UPDATE Marcas
                SET Nombre_Marca = ?
                WHERE id_Marca = ?';
        $params = array($this->nombreMarca, $this->idMarca);
        return Database::executeRow($sql, $params);
    }

    // Función para eliminar una marca
    public function deleteRow()
    {
        $sql = 'DELETE FROM Marcas
                WHERE id_Marca = ?';
        $params = array($this->idMarca);
        return Database::executeRow($sql, $params);
    }
}
?>
