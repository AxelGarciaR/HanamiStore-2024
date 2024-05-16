<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/ordenes_handler.php');
/*
 *  Clase para manejar el encapsulamiento de los datos de la tabla CATEGORIA.
 */
class OrdenesData extends OrdenesHandler
{
    /*
     *  Atributos adicionales.
     */
    private $data_error = null;

    /*
     *  Métodos para validar y establecer los datos.
     */
    public function setIdOrden($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idOrden = $value;
            return true;
        } else {
            $this->data_error = 'El identificador de la orden es incorrecto';
            return false;
        }
    }

    public function setIdCliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idCliente = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del cliente es incorrecto';
            return false;
        }
    }

    public function setFechaOrden($value)
    {
        if (Validator::validateDate($value)) {
            $this->fechaOrden = $value;
            return true;
        } else {
            $this->data_error = 'El formato de fecha es incorrecto';
            return false;
        }
    }

    public function setEstadoOrden($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estadoOrden = $value;
            return true;
        } else {
            $this->data_error = 'El estado orden es incorrecto';
            return false;
        }
    }

    /*
     *  Métodos para obtener los atributos adicionales.
     */
    public function getDataError()
    {
        return $this->data_error;
    }

}
