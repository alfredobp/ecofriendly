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
    estado varchar(255),
    fecha_nac date,
    token_acti VARCHAR(255),
    codigo_verificacion VARCHAR(255)
);

DROP TABLE IF EXISTS ranking CASCADE;

CREATE TABLE ranking (
    id bigserial PRIMARY KEY,
    puntuacion integer,
    usuariosid bigint NOT NULL UNIQUE REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS bloqueos CASCADE;

CREATE TABLE bloqueos (
    id bigserial PRIMARY KEY,
    usuariosid bigint NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
    bloqueadosid bigint NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS feeds CASCADE;

CREATE TABLE feeds (
    id bigserial PRIMARY KEY,
    usuariosid bigint NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
    contenido varchar(255) NOT NULL,
    created_at timestamp,
    updated_at timestamp
);

DROP TABLE IF EXISTS comentarios CASCADE;

CREATE TABLE comentarios (
    id bigserial PRIMARY KEY,
    usuario_id bigint NOT NULL REFERENCES usuarios(id)  ON DELETE CASCADE ON UPDATE CASCADE,
    contenido varchar(255) NOT NULL,
    created_at timestamp,
    updated_at timestamp,
    deleted boolean,
    comentarios_id bigint REFERENCES feeds(id)
);

DROP TABLE IF EXISTS seguidores CASCADE;

CREATE TABLE seguidores (
    id bigserial PRIMARY KEY,
    usuario_id bigint NOT NULL REFERENCES usuarios(id)  ON DELETE CASCADE ON UPDATE CASCADE,
    seguidor_id bigint NOT NULL NOT NULL REFERENCES usuarios(id)  ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS notificaciones CASCADE;

DROP TABLE IF EXISTS tipos_notificaciones CASCADE;

CREATE TABLE tipos_notificaciones (
    id bigserial PRIMARY KEY,
    tipo varchar (255)
);

CREATE TABLE notificaciones (
    id bigserial PRIMARY KEY,
    usuario_id bigint NOT NULL REFERENCES usuarios(id),
    seguidor_id bigint NOT NULL,
    leido boolean,
    tipo_notificacion_id integer NOT NULL REFERENCES tipos_notificaciones(id)  ON DELETE CASCADE ON UPDATE CASCADE,
    created_at timestamp
);

DROP TABLE IF EXISTS tipos_eco_retos CASCADE;

CREATE TABLE tipos_eco_retos (
    id bigserial PRIMARY KEY,
    tipo varchar(255)
);

DROP TABLE IF EXISTS eco_retos CASCADE;

CREATE TABLE eco_retos (
    id bigserial PRIMARY KEY,
    usuario_id bigint REFERENCES usuarios(id)  ON DELETE CASCADE ON UPDATE CASCADE,
    descripcion varchar(255),
    categoria_id integer REFERENCES tipos_eco_retos(id)  ON DELETE CASCADE ON UPDATE CASCADE,
    puntaje integer
);

DROP TABLE IF EXISTS mensajes_privados CASCADE;

CREATE TABLE mensajes_privados (
    id bigserial PRIMARY KEY,
    emisor_id bigserial REFERENCES usuarios(id)  ON DELETE CASCADE ON UPDATE CASCADE,
    receptor_id bigserial REFERENCES usuarios(id)  ON DELETE CASCADE ON UPDATE CASCADE,
    asunto varchar(255),
    contenido varchar(255),
    seen boolean,
    created_at timestamp,
    visto_dat timestamp
);

INSERT INTO
    usuarios (
        username,
        nombre,
        apellidos,
        email,
        contrasena,
        direccion,
        estado
    )
VALUES
    (
        'demo',
        'demo',
        'demo',
        'alfredobape@gmail.com',
        crypt('demo', gen_salt('bf', 10)),
        'c/ Isabel II 1º ',
        'estoy cansado'
    );

INSERT INTO
    usuarios (
        username,
        nombre,
        apellidos,
        email,
        contrasena,
        direccion,
        estado
    )
VALUES
    (
        'demo1',
        'demo1',
        'demo1',
        'alfredo.barragan@iesdonana.org',
        crypt('demo1', gen_salt('bf', 10)),
        'c/ Munilla II 1º ',
        'estoy motivado'
    );

INSERT INTO
    tipos_eco_retos (tipo)
VALUES
    ('deporte', 'estilo de vida', 'naturaleza');

INSERT INTO
    tipos_eco_retos (tipo)
VALUES
    ('estilo de vida');

INSERT INTO
    tipos_eco_retos (tipo)
VALUES
    ('naturaleza');