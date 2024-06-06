<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/detalle_ordenes_handler.php');
/*
*	Clase para manejar el encapsulamiento de los datos de las tablas PEDIDO y DETALLE_PEDIDO.
*/
class DetalleOrdenData extends DetalleOrdenHandler
{
    // Atributo genérico para manejo de errores.
    private $data_error = null;

    /*
    *   Métodos para validar y establecer los datos.
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

    public function setIdDetalle($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idDetalle = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del detalle de la orden es incorrecto';
            return false;
        }
    }

    public function setCliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cliente = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del cliente es incorrecto';
            return false;
        }
    }

    public function setProducto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->producto = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del producto es incorrecto';
            return false;
        }
    }

    public function setCantidad($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidad = $value;
            return true;
        } else {
            $this->data_error = 'La cantidad del producto debe ser mayor o igual a 1';
            return false;
        }
    }

    public function setComentario($value, $min = 2, $max = 250)
    {
        if (!Validator::validateAlphabetic($value)) {
            $this->data_error = 'El comentario debe ser un valor alfabético';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->comentario = $value;
            return true;
        } else {
            $this->data_error = 'El comentario debe de tener una longitud de ' . $min . ' y ' . $max;
            return false;
        }
    }

    public function setPuntuacion($value, $min = 1, $max = 1)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->puntuacion = $value;
            return true;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->puntuacion = $value;
            return true;
        } else {
            $this->data_error = 'El valor de la valoracion solo puede ser un valor de un digito';
            return false;
        }
    }

    // Método para obtener el error de los datos.
    public function getDataError()
    {
        return $this->data_error;
    }
}
