<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/marcas_handler.php');

class MarcasData extends MarcasHandler
{

    // Atributo para el manejo de errores
    private $data_error = null;

    // Función para validar el id de la marca
    public function setIdMarca($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idMarca = $value;
            return true;
        } else {
            $this->data_error = 'El identificador de la marca es incorrecto';
            return false;
        }
    }

    // Función para validar el nombre de la marca
    public function setNombreMarca($value, $min = 2, $max = 50)
    {
        if (!Validator::validateAlphabetic($value)) {
            $this->data_error = 'El nombre de la marca debe ser un valor alfabético';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->nombreMarca = $value;
            return true;
        } else {
            $this->data_error = 'El nombre de la marca debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    // Función para obtener el error
    public function getDataError()
    {
        return $this->data_error;
    }
}
?>