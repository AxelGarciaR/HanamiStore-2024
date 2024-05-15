<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/valoraciones_handler.php');

class ValoracionesData extends ValoracionesHandler
{

    //Atributo Para el manejo de errores
    private $data_error = null;

    //Funcion para validar el id
    public function setIdValoracion($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            $this->data_error = 'El identificador de la varloracion es incorrecto';
            return false;
        }
    }

    //Funcion para validar el id
    public function setValoracion($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->valoracion = $value;
            return true;
        } else {
            $this->data_error = 'La valoracion es incorrecta';
            return false;
        }
    }

    public function setIdDetalle($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idDetalle = $value;
            return true;
        } else {
            $this->data_error = 'La valoracion es incorrecta';
            return false;
        }
    }

    //Funcion para validar el el nombre de usuario
    public function setComentario($value, $min = 2, $max = 100)
    {
        if (!Validator::validateAlphabetic($value)) {
            $this->data_error = 'El nombre debe ser un valor alfabético';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->comentario = $value;
            return true;
        } else {
            $this->data_error = 'El comentario debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    //Funcion para validar la fecha del comentario
    public function setFechaComentario($value)
    {
        if (Validator::validateDate($value)) {
            $this->fechaComentario = $value;
            return true;
        } else {
            $this->data_error = 'La fecha esta en formato incorrecto';
            return false;
        }
    }

    public function setEstadoComentario($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estadoComentario = $value;
            return true;
        } else {
            $this->data_error = 'Error en el estado del comentario';
            return false;
        }
    }
    
    //Funcion para obtener el error
    public function getDataError()
    {
        return $this->data_error;
    }
}
