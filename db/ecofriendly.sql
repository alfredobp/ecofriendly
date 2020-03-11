------------------------------
-- Archivo de base de datos --
------------------------------
DROP TABLE IF EXISTS usuarios CASCADE;
CREATE TABLE usuarios (
    id bigserial PRIMARY KEY,
    username varchar(15) NOT NULL UNIQUE,
    contrasena varchar(255),
    auth_key varchar(255),
    nombre varchar(255) NOT NULL,
    apellidos varchar(255) NOT NULL,
    email varchar(50) NOT NULL UNIQUE,
    direccion varchar(255),
    fecha_nac date,
    token_acti VARCHAR(255)
);

Insert Into
    usuarios (username, contrasena, nombre, apellidos, email)
values
    (
        'pepito',
        'pepe',
        'pepe',
        'Romani',
        'peperro@gmail.com'
    )