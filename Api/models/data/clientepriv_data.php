<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/clientepriv_handler.php');
/*
 *  Clase para manejar el encapsulamiento de los datos de la tabla CATEGORIA.
 */
class ClientePrivData extends ClientePrivHandler
{
    /*
     *  Atributos adicionales.
     */
    private $data_error = null;

    /*
     *  Métodos para validar y establecer los datos.
     */
    public function setIdCliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idCliente = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del cliente no es correcto';
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