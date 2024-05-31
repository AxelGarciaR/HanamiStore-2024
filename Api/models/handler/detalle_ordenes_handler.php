<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla CATEGORIA.
 */
class DetalleOrdenHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $idOrden = null;
    protected $idDetalle = null;
    protected $cliente = null;
    protected $producto = null;
    protected $cantidad = null;
    protected $estado = null;


    /*
   /*
    *   ESTADOS DEL PEDIDO
    *   Pendiente (valor por defecto en la base de datos). Pedido en proceso y se puede modificar el detalle.
    *   Finalizado. Pedido terminado por el cliente y ya no es posible modificar el detalle.
    *   Entregado. Pedido enviado al cliente.
    *   Anulado. Pedido cancelado por el cliente después de ser finalizado.
    */

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
    */
    // Método para verificar si existe un pedido en proceso con el fin de iniciar o continuar una compra.
    public function getOrder()
    {
        $this->estado = 'Pendiente';
        $sql = 'SELECT id_Orden 
                FROM ordenes 
                WHERE Estado_Orden  = ? AND id_Cliente = ?';
        $params = array($this->estado, $_SESSION['idCliente']);
        if ($data = Database::getRow($sql, $params)) {
            $_SESSION['idOrden'] = $data['id_Orden'];
            return true;
        } else {
            return false;
        }
    }

    // Método para iniciar un pedido en proceso.
    public function startOrder()
    {
        if ($this->getOrder()) {
            return true;
        } else {
            $sql = 'INSERT INTO ordenes(direccion , id_Cliente)
                    VALUES((SELECT Direccion FROM clientes WHERE id_cliente = ?), ?)';
            $params = array($_SESSION['idCliente'], $_SESSION['idCliente']);
            // Se obtiene el ultimo valor insertado de la llave primaria en la tabla pedido.
            if ($_SESSION['idOrden'] = Database::getLastRow($sql, $params)) {
                return true;
            } else {
                return false;
            }
        }
    }

    // Método para agregar un producto al carrito de compras.
    public function createDetail()
    {
        // Se realiza una subconsulta para obtener el precio del producto.
        $sql = 'INSERT INTO detalleOrdenes(id_producto, precio_unitario, cantidad, id_orden)
                VALUES(?, (SELECT precio_producto FROM producto WHERE id_Producto = ?), ?, ?)';
        $params = array($this->producto, $this->producto, $this->cantidad, $_SESSION['idOrden']);
        return Database::executeRow($sql, $params);
    }

    // Método para obtener los productos que se encuentran en el carrito de compras.(Seguir editando este) *****************************************************
    public function readDetail()
    {
        $sql = 'SELECT id_detalle, Nombre_Producto, detalleOrdenes.precio_unitario, detalleOrdenes.cantidad
                FROM detalleOrdenes
                INNER JOIN ordenes USING(id_Orden)
                INNER JOIN productos USING(id_Producto)
                WHERE id_Orden = ?';
        $params = array($_SESSION['idOrden']);
        return Database::getRows($sql, $params);
    }

    // Método para finalizar un pedido por parte del cliente.
    public function finishOrder()
    {
        $this->estado = 'Finalizado';
        $sql = 'UPDATE ordenes 
                SET Estado_Orden  = ?
                WHERE id_Orden  = ?';
        $params = array($this->estado, $_SESSION['idOrden']);
        return Database::executeRow($sql, $params);
    }

    // Método para actualizar la cantidad de un producto agregado al carrito de compras.
    public function updateDetail()
    {
        $sql = 'UPDATE detalleOrdenes
                SET cantidad  = ?
                WHERE id_detalle = ? AND id_orden = ?';
        $params = array($this->cantidad, $this->idDetalle, $_SESSION['idOrden']);
        return Database::executeRow($sql, $params);
    }

    // Método para eliminar un producto que se encuentra en el carrito de compras.
    public function deleteDetail()
    {
        $sql = 'DELETE FROM detalleOrdenes
                WHERE id_detalle = ? AND id_orden = ?';
        $params = array($this->idDetalle, $_SESSION['idOrden']);
        return Database::executeRow($sql, $params);
    }
}
