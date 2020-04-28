------------------------------
-- Archivo de base de datos --
------------------------------
DROP TABLE IF EXISTS ecoretos CASCADE;

CREATE TABLE ecoretos (
    id bigserial PRIMARY KEY,
    categoria_id integer NOT NULL UNIQUE,
    cat_nombre varchar(255)
);

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios (
    id bigserial PRIMARY KEY,
    username varchar(15) NOT NULL UNIQUE,
    contrasena varchar(255),
    auth_key varchar(255),
    nombre varchar(255) NOT NULL,
    apellidos varchar(255) NOT NULL,
    email varchar(50) NOT NULL UNIQUE,
    url_avatar varchar(255),
    direccion varchar(255),
    provincia varchar(255),
    localidad varchar(255),
    estado varchar(255),
    fecha_nac date NOT NULL,
    token_acti VARCHAR(255),
    rol VARCHAR(30) NOT NULL DEFAULT 'usuario',
    codigo_verificacion VARCHAR(255),
    ultima_conexion timestamp,
    fecha_alta timestamp(0) NOT NULL DEFAULT current_timestamp,
    categoria_id integer REFERENCES ecoretos(categoria_id)
);

DROP TABLE IF EXISTS acciones_retos CASCADE;

CREATE TABLE acciones_retos (
    id bigserial PRIMARY KEY,
    titulo varchar(255) NOT NULL,
    descripcion varchar(255) NOT NULL,
    cat_id integer REFERENCES ecoretos(categoria_id),
    puntaje integer
);

DROP TABLE IF EXISTS retos_usuarios CASCADE;

CREATE TABLE retos_usuarios (
    id bigserial NOT NULL,
    idReto integer REFERENCES acciones_retos(id),
    usuario_id integer REFERENCES usuarios(id),
    fecha_aceptacion timestamp NOT NULL DEFAULT current_timestamp,
    fecha_culminacion timestamp,
    culminado boolean default false,
    CONSTRAINT retoId PRIMARY KEY (usuario_id, idReto)
);

DROP TABLE IF EXISTS ranking CASCADE;

CREATE TABLE ranking (
    id bigserial PRIMARY KEY,
    puntuacion integer,
    usuariosid bigint NOT NULL UNIQUE REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CHECK (puntuacion < 101)
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
    imagen varchar(255),
    created_at timestamp(0) NOT NULL DEFAULT current_timestamp,
    updated_at timestamp
);

DROP TABLE IF EXISTS comentarios CASCADE;

CREATE TABLE comentarios (
    id bigserial PRIMARY KEY,
    usuario_id bigint NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
    contenido varchar(255) NOT NULL,
    created_at timestamp,
    updated_at timestamp,
    deleted boolean,
    comentarios_id bigint REFERENCES feeds(id)
);

DROP TABLE IF EXISTS seguidores CASCADE;

CREATE TABLE seguidores (
    id bigserial PRIMARY KEY,
    usuario_id bigint NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
    seguidor_id bigint NOT NULL NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
    fecha_seguimiento timestamp(0) NOT NULL DEFAULT current_timestamp
);

DROP TABLE IF EXISTS tipos_notificaciones CASCADE;

CREATE TABLE tipos_notificaciones (
    id bigserial PRIMARY KEY,
    tipo varchar (255)
);

DROP TABLE IF EXISTS notificaciones CASCADE;

CREATE TABLE notificaciones (
    id bigserial PRIMARY KEY,
    usuario_id bigint NOT NULL REFERENCES usuarios(id),
    seguidor_id bigint NOT NULL,
    leido boolean,
    tipo_notificacion_id integer NOT NULL REFERENCES tipos_notificaciones(id) ON DELETE CASCADE ON UPDATE CASCADE,
    created_at timestamp
);

DROP TABLE IF EXISTS mensajes_privados CASCADE;

CREATE TABLE mensajes_privados (
    id bigserial PRIMARY KEY,
    emisor_id bigserial REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
    receptor_id bigserial REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
    asunto varchar(255),
    contenido varchar(255),
    seen boolean,
    created_at timestamp,
    visto_dat timestamp
);

INSERT into
    ecoretos(cat_nombre, categoria_id)
VALUES
    ('Principante', 1);

INSERT into
    ecoretos(cat_nombre, categoria_id)
VALUES
    ('Intermedio', 2);

INSERT into
    ecoretos(cat_nombre, categoria_id)
VALUES
    ('Avanzado', 3);

INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Reducir la contaminación del aire',
        'Usar o compartir el coche al menos 3 veces por semana',
        1,
        9
    );

INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Promover una producción más sostenible y respetuosa con el medio ambiente',
        'Consumir alimentos respetuosos con el medio ambiente, etiqueta eco, productos resposables,...',
        1,
        12
    );

INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Reducir la cantidad de residuos no biodegradables',
        'Usar mis propias bolsas para hacer la compra',
        1,
        12
    );

INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Intentar vivir sin plásticos',
        'Reducir los utensilios de plasticos en mi hogar',
        2,
        9
    );

INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Reducir el consumo de energía',
        'Reciclar y reducir los residuos domésticos',
        2,
        9
    );

INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Disminuir el consumo de agua y contaminación',
        'Controlar los tiempos de ducha y/o reducir el número de baños en casa',
        2,
        6
    );

INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Hacer un uso eficiente de la energía consumida por mi hogar',
        'Reemplazar los electrodomésticos y bombillas por elementos más eficientes.',
        3,
        7
    );

INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Reducir la huella hidrica de tu hogar',
        'Instalar sistema de doble descarga y sistenas de control de caudal: atomizadores, temporizadores, en cuartos de baños y cocinas',
        3,
        5
    );

INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Vivir de forma más respetuosa con el medio ambiente',
        'Aplicar la norma 20/80 en tu estilo de vida',
        3,
        12
    );

INSERT INTO
    usuarios (
        username,
        nombre,
        apellidos,
        email,
        contrasena,
        direccion,
        estado,
        rol
       
    )
VALUES
    (
        'admin',
        'admin',
        'admin',
        'alfredobsape@gmail.com',
        crypt('adminadmin', gen_salt('bf', 10)),
        'c/ Isabel II 1º ',
        'Soy el Administrador de la plataforma',
        'superadministrador'
     
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
        crypt('demodemo', gen_salt('bf', 10)),
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
        provincia,
        localidad,
        direccion,
        estado
    )
VALUES
    (
        'demo1',
        'demo1',
        'demo1',
        'alfredo.barra2gan@iesdonana.org',
        crypt('adminadmin', gen_salt('bf', 10)),
        'Cádiz',
        'Sanlúcar de barrameda',
        'Munilla II 1 a ',
        'estoy cansadito'
    );

INSERT INTO
    usuarios (
        username,
        nombre,
        apellidos,
        email,
        contrasena,
        localidad,
        direccion,
        estado
    )
VALUES
    (
        'demo2',
        'demo2',
        'demo2',
        'alfredo.barragan@iesdonana.org',
        crypt('demo2demo2', gen_salt('bf', 10)),
        'rota',
        'Munilla II 1 a ',
        'estoy cansadito'
    );