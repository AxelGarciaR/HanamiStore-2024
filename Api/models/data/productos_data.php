<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/productos_handler.php');

class ProductosData extends ProductosHandler
{

    //Atributo Para el manejo de errores
    private $data_error = null;
    private $filename = null;

    //Funcion para validar el id
    public function setIdProducto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del producto es incorrecto';
            return false;
        }
    }

    //Funcion para validar el el nombre de usuario
    public function setNombreProducto($value, $min = 2, $max = 100)
    {
        if (!Validator::validateAlphabetic($value)) {
            $this->data_error = 'El nombre debe ser un valor alfabético';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->nombreProducto = $value;
            return true;
        } else {
            $this->data_error = 'El nombre debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    //Funcion para validar el tamano de la descripcion
    public function setDescripcionProducto($value, $min = 2, $max = 100)
    {
        if (Validator::validateLength($value, $min, $max)) {
            $this->nombreProducto = $value;
            return true;
        } else {
            $this->data_error = 'La descripcion del producto debe ser entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    //Funcion para validar el precio del producto
    public function setPrecioProducto($value)
    {
        if (Validator::validateMoney($value)) {
            $this->precioProducto = $value;
            return true;
        } else {
            $this->data_error = 'El precio del producto esta en formato incorrecto';
            return false;
        }
    }

    //Funcion para validar validar el nombre del archivo
    public function setFilename()
    {
        if ($data = $this->readFilename()) {
            $this->filename = $data['imagenPrincipal'];
            return true;
        } else {
            $this->data_error = 'Producto inexistente';
            return false;
        }
    }

    //Funcion para validar el validar la imagen
    public function setImagen($file, $filename = null)
    {
        if (Validator::validateImageFile($file, 1000)) {
            $this->imagenPrincipal = Validator::getFileName();
            return true;
        } elseif (Validator::getFileError()) {
            $this->data_error = Validator::getFileError();
            return false;
        } elseif ($filename) {
            $this->imagenPrincipal = $filename;
            return true;
        } else {
            $this->imagenPrincipal = 'default.png';
            return true;
        }
    }

    //Funcion para validar la cantidad del producto
    public function setCantidadProducto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidadProducto = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del usuario es incorrecto';
            return false;
        }
    }

    //Funcion para validar el validar el id de la subcategoria
    public function setidSubcategoria($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idSubcategoria = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del usuario es incorrecto';
            return false;
        }
    }

    //Funcion para validar el descuento
    public function setDescuento($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->descuento = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del usuario es incorrecto';
            return false;
        }
    }

    //Funcion para validar el validar el id de la marca
    public function setIdMarca($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->marca = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del usuario es incorrecto';
            return false;
        }
    }

    //Funcion para obtener el error
    public function getDataError()
    {
        return $this->data_error;
    }

    //Funcion para obtener el nombre del archivo
    public function getFilename()
    {
        return $this->filename;
    }
}
