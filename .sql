CREATE TABLE usuario(
usuario_id SERIAL PRIMARY KEY,
usuario_nom1 VARCHAR (50) NOT NULL,
usuario_nom2 VARCHAR (50) NOT NULL,
usuario_ape1 VARCHAR (50) NOT NULL,
usuario_ape2 VARCHAR (50) NOT NULL,
usuario_tel INT NOT NULL, 
usuario_direc VARCHAR (150) NOT NULL,
usuario_dpi VARCHAR (13) NOT NULL,
usuario_correo VARCHAR (100) NOT NULL,
usuario_contra LVARCHAR (1056) NOT NULL,
usuario_token LVARCHAR (1056) NOT NULL,
usuario_fecha_creacion DATE DEFAULT TODAY,
usuario_fecha_contra DATE DEFAULT TODAY,
usuario_fotografia LVARCHAR (2056),
usuario_situacion SMALLINT DEFAULT 1
);

CREATE TABLE aplicacion(
app_id SERIAL PRIMARY KEY,
app_nombre_largo VARCHAR (250) NOT NULL,
app_nombre_medium VARCHAR (150) NOT NULL,
app_nombre_corto VARCHAR (50) NOT NULL,
app_fecha_creacion DATE DEFAULT TODAY,
app_situacion SMALLINT DEFAULT 1
);

CREATE TABLE permiso(
permiso_id SERIAL PRIMARY KEY, 
permiso_app_id INT NOT NULL,
permiso_nombre VARCHAR (150) NOT NULL,
permiso_clave VARCHAR (250) NOT NULL,
permiso_desc VARCHAR (250) NOT NULL,
permiso_fecha DATETIME YEAR TO SECOND DEFAULT CURRENT YEAR TO SECOND,
permiso_situacion SMALLINT DEFAULT 1,
FOREIGN KEY (permiso_app_id) REFERENCES aplicacion(app_id)
);

CREATE TABLE asig_permisos(
asignacion_id SERIAL PRIMARY KEY,
asignacion_usuario_id INT NOT NULL,
asignacion_app_id INT NOT NULL,
asignacion_permiso_id INT NOT NULL,
asignacion_fecha DATETIME YEAR TO SECOND DEFAULT CURRENT YEAR TO SECOND,
asignacion_quitar_fechapermiso DATETIME YEAR TO SECOND DEFAULT CURRENT YEAR TO SECOND,
asignacion_usuario_asigno INT NOT NULL,
asignacion_motivo VARCHAR (250) NOT NULL,
asignacion_situacion SMALLINT DEFAULT 1,
FOREIGN KEY (asignacion_usuario_id) REFERENCES usuario(usuario_id),
FOREIGN KEY (asignacion_app_id) REFERENCES aplicacion(app_id),
FOREIGN KEY (asignacion_permiso_id) REFERENCES permiso(permiso_id)
);

CREATE TABLE rutas(
ruta_id SERIAL PRIMARY KEY,
ruta_app_id INT NOT NULL,
ruta_nombre LVARCHAR (1056) NOT NULL,
ruta_descripcion VARCHAR (250) NOT NULL,
ruta_situacion SMALLINT DEFAULT 1,
FOREIGN KEY (ruta_app_id) REFERENCES aplicacion(app_id)
);

CREATE TABLE historial_act(
historial_id SERIAL PRIMARY KEY,
historial_usuario_id INT NOT NULL,
historial_fecha DATETIME YEAR TO MINUTE,
historial_ruta INT NOT NULL,
historial_ejecucion LVARCHAR (1056) NOT NULL,
historial_status INT,
historial_situacion SMALLINT DEFAULT 1,
FOREIGN KEY (historial_usuario_id) REFERENCES usuario(usuario_id),
FOREIGN KEY (historial_ruta) REFERENCES rutas(ruta_id)
);

CREATE TABLE marca (
    mar_id SERIAL PRIMARY KEY,
    mar_nombre VARCHAR(50) NOT NULL,
    mar_descripcion VARCHAR(200),
    mar_situacion SMALLINT DEFAULT 1
);

CREATE TABLE cliente (
    cli_id SERIAL PRIMARY KEY,
    cli_nombre VARCHAR(100) NOT NULL,
    cli_apellido VARCHAR(100) NOT NULL,
    cli_nit INT NOT NULL,
    cli_telefono INT NOT NULL,
    cli_direccion VARCHAR(200),
    cli_situacion SMALLINT DEFAULT 1
);

CREATE TABLE inventario (
    inv_id SERIAL PRIMARY KEY,
    inv_modelo VARCHAR(100) NOT NULL,
    inv_marca_id INT NOT NULL,
    inv_precio_compra DECIMAL(10,2) NOT NULL,
    inv_precio_venta DECIMAL(10,2) NOT NULL,
    inv_stock INT DEFAULT 0,
    inv_descripcion VARCHAR(250),
    inv_situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (inv_marca_id) REFERENCES marca(mar_id)
);

CREATE TABLE venta (
    ven_id SERIAL PRIMARY KEY,
    ven_cliente_id INT NOT NULL,
    ven_inventario_id INT NOT NULL,
    ven_cantidad INT NOT NULL,
    ven_precio_unitario DECIMAL(10,2) NOT NULL,
    ven_total DECIMAL(10,2) NOT NULL,
    ven_fecha DATETIME YEAR TO SECOND,
    ven_observaciones VARCHAR(250),
    ven_situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (ven_cliente_id) REFERENCES cliente(cli_id),
    FOREIGN KEY (ven_inventario_id) REFERENCES inventario(inv_id)
);

CREATE TABLE reparacion (
    rep_id SERIAL PRIMARY KEY,
    rep_cliente_id INT NOT NULL,
    rep_equipo VARCHAR(100) NOT NULL,
    rep_marca VARCHAR(50) NOT NULL,
    rep_falla VARCHAR(250) NOT NULL,
    rep_diagnostico VARCHAR(250),
    rep_costo DECIMAL(10,2),
    rep_fecha_ingreso DATETIME YEAR TO SECOND,
    rep_fecha_entrega DATE,
    rep_estado VARCHAR(20) DEFAULT 'RECIBIDO',
    rep_observaciones VARCHAR(250),
    rep_situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (rep_cliente_id) REFERENCES cliente(cli_id)
);

CREATE TABLE historial_venta (
    his_id SERIAL PRIMARY KEY,
    his_venta_id INT NOT NULL,
    his_fecha DATETIME YEAR TO SECOND,
    his_cliente VARCHAR(200) NOT NULL,
    his_producto VARCHAR(200) NOT NULL,
    his_cantidad INT NOT NULL,
    his_total DECIMAL(10,2) NOT NULL,
    his_tipo VARCHAR(20) DEFAULT 'VENTA',
    his_situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (his_venta_id) REFERENCES venta(ven_id)
);

INSERT INTO marca (mar_nombre, mar_descripcion) VALUES 
('Samsung', 'Marca coreana líder en tecnología');
INSERT INTO marca (mar_nombre, mar_descripcion) VALUES 
('Apple', 'Marca americana premium');
INSERT INTO marca (mar_nombre, mar_descripcion) VALUES 
('Xiaomi', 'Marca china con excelente relación calidad-precio');
INSERT INTO marca (mar_nombre, mar_descripcion) VALUES 
('Huawei', 'Marca china especializada en telecomunicaciones');
INSERT INTO marca (mar_nombre, mar_descripcion) VALUES 
('Motorola', 'Marca americana clásica');