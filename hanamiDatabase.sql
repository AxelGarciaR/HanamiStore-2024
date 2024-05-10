-- Creación de la base de datos
DROP DATABASE IF EXISTS hanamistore; 
CREATE DATABASE IF NOT EXISTS hanamistore;
USE hanamistore;

-- Creación de la tabla usuarios
CREATE TABLE IF NOT EXISTS usuarios (
  id_usuario INT PRIMARY KEY AUTO_INCREMENT,
  nombre_usuario VARCHAR(100),
  clave VARCHAR(100),
  correo VARCHAR(100),
  imagen VARCHAR(100)
);

-- Creación de la tabla clientes
CREATE TABLE IF NOT EXISTS clientes (
  id_cliente INT PRIMARY KEY AUTO_INCREMENT,
  nombre_cliente VARCHAR(50),
  apellido_cliente VARCHAR(50),
  nombre_perfil VARCHAR(50),
  clave VARCHAR(100),
  CorreoE VARCHAR(100),
  Direccion VARCHAR(100)
);

-- Creación de la tabla ordenes
CREATE TABLE IF NOT EXISTS ordenes (
  id_Orden INT PRIMARY KEY AUTO_INCREMENT,
  id_Cliente INT,
  Fecha_Orden DATE NOT NULL,
  Estado_Orden BOOLEAN NOT NULL,
  FOREIGN KEY (id_Cliente) REFERENCES clientes (id_cliente)
);

-- Creación de la tabla categorias
CREATE TABLE IF NOT EXISTS categorias (
  id_Categoria INT PRIMARY KEY AUTO_INCREMENT,
  Nombre_Categoria VARCHAR(50) NOT NULL
);

-- Creación de la tabla sub_categorias
CREATE TABLE IF NOT EXISTS sub_categorias (
  id_SubCategoria INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(50) NOT NULL,
  id_Categoria INT NOT NULL,
  FOREIGN KEY (id_Categoria) REFERENCES categorias (id_Categoria)
);

-- Creación de la tabla marcas
CREATE TABLE IF NOT EXISTS marcas (
  id_Marca INT PRIMARY KEY AUTO_INCREMENT,
  Nombre_Marca VARCHAR(50) NOT NULL,
  Logo_Marca VARCHAR(100) NOT NULL
);

-- Creación de la tabla productos
CREATE TABLE IF NOT EXISTS productos (
  id_Producto INT PRIMARY KEY AUTO_INCREMENT,
  Nombre_Producto VARCHAR(100) NOT NULL,
  descripcion_producto VARCHAR(100) NOT NULL,
  precio_producto DOUBLE(10, 2) NOT NULL,
  imagen_principal VARCHAR(100) NOT NULL,
  CantidadP INT NOT NULL,
  id_subcategoria INT NOT NULL,
  descuento INT,
  id_Marca INT NOT NULL,
  FOREIGN KEY (id_subcategoria) REFERENCES sub_categorias (id_SubCategoria),
  FOREIGN KEY (id_Marca) REFERENCES marcas (id_Marca)
);

-- Creación de la tabla imagenes
CREATE TABLE IF NOT EXISTS imagenes (
  id_imagen INT PRIMARY KEY AUTO_INCREMENT,
  id_producto INT,
  ruta VARCHAR(100),
  FOREIGN KEY (id_producto) REFERENCES productos (id_Producto)
);

-- Creación de la tabla detalleOrdenes
CREATE TABLE IF NOT EXISTS detalleOrdenes (
  id_detalle INT PRIMARY KEY AUTO_INCREMENT,
  id_orden INT,
  id_producto INT,
  cantidad INT,
  precio_unitario DOUBLE,
  FOREIGN KEY (id_orden) REFERENCES ordenes (id_Orden),
  FOREIGN KEY (id_producto) REFERENCES productos (id_Producto)
);

-- Creación de la tabla valoraciones
CREATE TABLE IF NOT EXISTS valoraciones (
  id_valoracion INT PRIMARY KEY AUTO_INCREMENT,
  Valoracion VARCHAR(5),
  id_detalle INT,
  comentario VARCHAR(100),
  fecha_comentario DATE,
  estado_comentario BOOLEAN,
  FOREIGN KEY (id_detalle) REFERENCES detalleOrdenes (id_detalle)
);

-- Restricciones de la tabla clientes
ALTER TABLE clientes
  ADD CONSTRAINT u_correo_cliente UNIQUE (CorreoE);

-- Restricciones de la tabla categorias
ALTER TABLE categorias
  ADD CONSTRAINT u_nombre_categoria UNIQUE (Nombre_Categoria);

-- Restricciones de la tabla sub_categorias
ALTER TABLE sub_categorias
  ADD CONSTRAINT u_nombre_subcategoria UNIQUE (nombre);

-- Restricciones de la tabla marcas
ALTER TABLE marcas
  ADD CONSTRAINT u_nombre_marca UNIQUE (Nombre_Marca);


-- procedimiento insertar clientes --
DELIMITER //

CREATE PROCEDURE InsertarCliente(
    IN p_nombre_cliente VARCHAR(50),
    IN p_apellido_cliente VARCHAR(50),
    IN p_nombre_perfil VARCHAR(50),
    IN p_clave VARCHAR(100),
    IN p_correo VARCHAR(100),
    IN p_direccion VARCHAR(100)
)
BEGIN
    INSERT INTO clientes (nombre_cliente, apellido_cliente, nombre_perfil, clave, CorreoE, Direccion)
    VALUES (p_nombre_cliente, p_apellido_cliente, p_nombre_perfil, p_clave, p_correo, p_direccion);
END //

DELIMITER ;

-- procedimiento actualizar cliente --

DELIMITER //

CREATE PROCEDURE ActualizarCliente(
    IN p_id_cliente INT,
    IN p_nombre_cliente VARCHAR(50),
    IN p_apellido_cliente VARCHAR(50),
    IN p_nombre_perfil VARCHAR(50),
    IN p_clave VARCHAR(100),
    IN p_correo VARCHAR(100),
    IN p_direccion VARCHAR(100)
)
BEGIN
    UPDATE clientes
    SET nombre_cliente = p_nombre_cliente,
        apellido_cliente = p_apellido_cliente,
        nombre_perfil = p_nombre_perfil,
        clave = p_clave,
        CorreoE = p_correo,
        Direccion = p_direccion
    WHERE id_cliente = p_id_cliente;
END //

DELIMITER ;


DELIMITER //

 -- insertar orden --
 DELIMITER //

CREATE PROCEDURE InsertarOrden(
    IN p_id_cliente INT,
    IN p_fecha_orden DATE,
    IN p_estado_orden BOOLEAN
)
BEGIN
    INSERT INTO ordenes (id_Cliente, Fecha_Orden, Estado_Orden)
    VALUES (p_id_cliente, p_fecha_orden, p_estado_orden);
END //

DELIMITER ;
-- insertar categoria --
DELIMITER //

CREATE PROCEDURE InsertarCategoria(
    IN p_nombre_categoria VARCHAR(50)
)
BEGIN
    INSERT INTO categorias (Nombre_Categoria)
    VALUES (p_nombre_categoria);
END //

DELIMITER ;
-- insertar sub categoria--
DELIMITER //

CREATE PROCEDURE InsertarSubCategoria(
    IN p_nombre_subcategoria VARCHAR(50),
    IN p_id_categoria INT
)
BEGIN
    INSERT INTO sub_categorias (nombre, id_Categoria)
    VALUES (p_nombre_subcategoria, p_id_categoria);
END //

DELIMITER ;
-- insertar marca --
DELIMITER //

CREATE PROCEDURE InsertarMarca(
    IN p_nombre_marca VARCHAR(50),
    IN p_logo_marca VARCHAR(100)
)
BEGIN
    INSERT INTO marcas (Nombre_Marca, Logo_Marca)
    VALUES (p_nombre_marca, p_logo_marca);
END //

DELIMITER ;
-- insertar producto--

DELIMITER //

CREATE PROCEDURE InsertarProducto(
    IN p_nombre_producto VARCHAR(100),
    IN p_descripcion_producto VARCHAR(100),
    IN p_precio_producto DOUBLE,
    IN p_imagen_principal VARCHAR(100),
    IN p_cantidad INT,
    IN p_id_subcategoria INT,
    IN p_descuento INT,
    IN p_id_marca INT
)
BEGIN
    INSERT INTO productos (Nombre_Producto, descripcion_producto, precio_producto, imagen_principal, CantidadP, id_subcategoria, descuento, id_Marca)
    VALUES (p_nombre_producto, p_descripcion_producto, p_precio_producto, p_imagen_principal, p_cantidad, p_id_subcategoria, p_descuento, p_id_marca);
END //

DELIMITER ;

DELIMITER //
CREATE TRIGGER check_password_expiry
BEFORE INSERT ON usuarios
FOR EACH ROW
BEGIN
    DECLARE last_password_change_date DATE;
    DECLARE current_date DATE;
    
    SELECT clave INTO last_password_change_date FROM usuarios WHERE id_usuario = NEW.id_usuario;
    SET current_date = CURDATE();
    
    IF DATEDIFF(current_date, last_password_change_date) > 90 THEN
        -- Aquí puedes agregar la acción que desees realizar cuando la contraseña ha expirado
        -- Por ejemplo, puedes imprimir un mensaje de advertencia o lanzar una excepción.
        -- En este ejemplo, solo se imprime un mensaje de advertencia.
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = '¡Advertencia! Han pasado más de 90 días desde que cambió su contraseña. Por favor, cambie su contraseña ahora.';
    END IF;
END //
DELIMITER ;
