<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/usuarios_handler.php');

/**Clase para manejar el encapsulamiento de los datos de usuario**/

class UsuarioData extends UsuariosHandler{

    //Atributo Para el manejo de errores
    private $data_error = null;
    private $filename = null;

    //Funciones para validar y establecer los datos
    
    //Funcion para validar el id
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del usuario es incorrecto';
            return false;
        }
    }

    //Funcion para validar el el nombre de usuario
    public function setNombreUsuario($value, $min = 2, $max = 100)
    {
        if (!Validator::validateAlphanumeric($value)) {
            $this->data_error = 'El nombre debe ser un valor alfabético';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->nombre = $value;
            return true;
        } else {
            $this->data_error = 'El nombre debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }
    
    //Funcion para validar el correo
    public function setCorreo($value)
    {
        if(!Validator::validateEmail($value)){
            $this->data_error = 'Ingrese un correo válido';
            return false;
        } else{
            $this->correo = $value;
            return true;
        }
    }
    
    //Funcion para validar la clave
    public function setClave($value)
    {
        if (Validator::validatePassword($value)) {
            $this->clave = password_hash($value, PASSWORD_DEFAULT);
            return true;
        } else {
            $this->data_error = Validator::getPasswordError();
            return false;
        }
    }

    //Funcion para obtener el error
    public function getDataError()
    {
        return $this->data_error;
    }


}