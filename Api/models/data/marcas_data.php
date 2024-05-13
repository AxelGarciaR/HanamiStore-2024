<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/marcas_handler.php');

class MarcasData extends MarcasHandler
{

    // Atributo para el manejo de errores
    private $data_error = null;
    private $filename = null;

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

    // Función para validar el nombre del archivo
    public function setLogoMarca($value, $min = 2, $max = 100)
    {
        if (Validator::validateLength($value, $min, $max)) {
            $this->logoMarca = $value;
            return true;
        } else {
            $this->data_error = 'El nombre del archivo del logo de la marca debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    // Función para validar el nombre del archivo
    public function setFilename()
    {
        if ($data = $this->readFilename()) {
            $this->filename = $data['Logo_Marca'];
            return true;
        } else {
            $this->data_error = 'Marca inexistente';
            return false;
        }
    }

    // Función para validar la imagen del logo
    public function setLogoMarcaFile($file, $filename = null)
    {
        if (Validator::validateImageFile($file, 1000)) {
            $this->logoMarca = Validator::getFileName();
            return true;
        } elseif (Validator::getFileError()) {
            $this->data_error = Validator::getFileError();
            return false;
        } elseif ($filename) {
            $this->logoMarca = $filename;
            return true;
        } else {
            $this->data_error = 'No se pudo cargar el logo de la marca';
            return false;
        }
    }

    // Función para obtener el error
    public function getDataError()
    {
        return $this->data_error;
    }

    // Función para obtener el nombre del archivo
    public function getFilename()
    {
        return $this->filename;
    }
}
