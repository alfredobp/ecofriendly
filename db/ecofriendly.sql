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
    descripcion text,
    fecha_nac date NOT NULL,
    token_acti VARCHAR(255),
    rol VARCHAR(30) NOT NULL DEFAULT 'usuario',
    codigo_verificacion VARCHAR(255),
    ultima_conexion timestamp,
    fecha_alta timestamp(0) NOT NULL DEFAULT current_timestamp,
    categoria_id integer REFERENCES ecoretos(categoria_id)
);

DROP TABLE IF EXISTS usuarios_actividad CASCADE;

CREATE TABLE usuarios_actividad(
    id bigserial PRIMARY KEY,
    usuario_id integer UNIQUE REFERENCES usuarios(id),
    motivo varchar NOT NULL,
    fecha_suspenso timestamp(0) NOT NULL DEFAULT current_timestamp
);

DROP TABLE IF EXISTS objetivos_personales CASCADE;

CREATE TABLE objetivos_personales(
    id bigserial PRIMARY KEY,
    usuario_id integer REFERENCES usuarios(id),
    objetivo varchar,
    created_at timestamp(0) NOT NULL DEFAULT current_timestamp
);

DROP TABLE IF EXISTS acciones_retos CASCADE;

CREATE TABLE acciones_retos (
    id bigserial PRIMARY KEY,
    titulo varchar(255) NOT NULL,
    descripcion varchar NOT NULL,
    cat_id integer REFERENCES ecoretos(categoria_id),
    puntaje integer
);

DROP TABLE IF EXISTS retos_usuarios CASCADE;

CREATE TABLE retos_usuarios (
    id bigserial NOT NULL,
    idReto integer REFERENCES acciones_retos(id),
    usuario_id integer REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
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
    comentarios_id bigint REFERENCES feeds(id) ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE if EXISTS feeds_favoritos CASCADE;

CREATE TABLE feeds_favoritos (
    id bigserial PRIMARY KEY,
    usuario_id bigint NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
    feed_id integer NOT NULL REFERENCES feeds(id) ON DELETE CASCADE ON UPDATE CASCADE,
    created_at timestamp(0) NOT NULL DEFAULT current_timestamp
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
    tipo varchar (255) NOT NUll 
);

DROP TABLE IF EXISTS notificaciones CASCADE;

CREATE TABLE notificaciones (
    id bigserial PRIMARY KEY,
    usuario_id bigint NOT NULL REFERENCES usuarios(id),
    seguidor_id bigint NOT NULL,
    leido boolean,
    tipo_notificacion_id integer NOT NULL REFERENCES tipos_notificaciones(id) ON DELETE CASCADE ON UPDATE CASCADE,
    created_at timestamp NOT NULL DEFAULT current_timestamp,
    id_evento integer
);

DROP TABLE IF EXISTS mensajes_privados CASCADE;

CREATE TABLE mensajes_privados (
    id bigserial PRIMARY KEY,
    emisor_id bigserial REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
    receptor_id bigserial REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
    asunto varchar(255),
    contenido varchar(255),
    seen boolean,
    created_at timestamp NOT NULL DEFAULT current_timestamp,
    visto_dat timestamp
);

INSERT into
    ecoretos(cat_nombre, categoria_id)
VALUES
    ('Principiante', 1);

INSERT into
    ecoretos(cat_nombre, categoria_id)
VALUES
    ('Intermedio', 2);

INSERT into
    ecoretos(cat_nombre, categoria_id)
VALUES
    ('Avanzado', 3);

-- Retos Categoría 1
INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Reducir la contaminación del aire',
        'Usar o compartir el coche al menos 3 veces por semana durante al menos un mes.',
        1,
        6
    );

INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Promover una producción más sostenible y respetuosa con el medio ambiente',
        'Consumir alimentos respetuosos con el medio ambiente, etiqueta eco, productos resposables,...',
        1,
        8
    );

INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Utilizar el transporte público',
        'En este reto debes intentar utilizar el trsnaporte público o medios más sostenibles para hacer tus 
        desplazamientos por la ciudad. Utiliza la bicicleta, patinete,... y se más #ecofriendly con el planeta.',
        1,
        7
    );

INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Reducir la cantidad de residuos no biodegradables',
        'Debes usar tus propias bolsas para hacer la compra, reciclar la ropa, o reutilizar antiguos elementos de tu hogar',
        1,
        9
    );

INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Envases ecofriendly',
        'Intenta comprar alimentos con el mínimo envase posible. Las marcas empiezan a concienciarse de este problema y buscan cada vez más soluciones.Unilever,
         a través de Dove, fue una de las primeras compañías en utilizar aerosoles comprimidos, lo que permite introducir más producto en el mismo envase y 
         reduce la emisión de carbono por envase en un 255%.',
        1,
        9
    );

-- Retos Categoría 2
INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Intentar vivir sin plásticos',
        'Debes reducir los utensilios de plasticos en tu hogar. Existen soluciones viables como sin plástico, que permiten sustituir todos esos productos
        ofreciendo alternativas más seguras y sostenibles',
        2,
        9
    );

INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Reducir el consumo de energía de tu hogar',
        'La producción de electricidad es una de las mayores actividades contaminantes de nuestro planeta, emitiendo miles de toneladas de gases de efecto invernadero a la
        atmósfera, por ello que este reto trata de nuestro poder como consumidores, reduciendo la cantidad de energía consumida y contratando con compañias más sotenibles',
        2,
        9
    );

INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Disminuir el consumo de agua y contaminación hídrica',
        'El consumo de agua que realizamos esta directemente relacionado con la cotaminación del agua, es por ello, que en este reto deber controlar los tiempos de ducha,
        reducir el número de baños en casa y sobre todo no tirando papeles, no toallitas al WC que provocan atascos y fallos en los procesos de depuración',
        2,
        6
    );

INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Trabajar 100 % digital',
        'Ya hay gran cantidad de empresas que han instaurado la dinámica de trabajar al 100% en digital y por tanto evitar la impresión constante e injustificada de papel. 
        Si no es tu caso, seguramente muchas decisiones las tomarán tus superiores, pero todavía hay muchos gestos que puedes tener para seguir con tu propósito de ser sostenible.
        En este reto debes de controlar el papel que gastas, por cada 12.000 folios se necesitan un árbol, así piensa en imprimir por las dos caras, utiliza papel reciclado, o simplemente
        no imprimas nada que no se absolutamente imprescindible',
        2,
        6
    );

-- Retos categoría 3
INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Hacer un uso eficiente de la energía consumida por mi hogar',
        'En este reto, debes intentar reemplazar los electrodomésticos y bombillas por elementos más eficientes. Desenchufar los dispositivos electrónicos cuando no lo utilicéis',
        3,
        4
    );

INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Reducir la huella hidrica de tu hogar',
        'Instalar sistema de doble descarga así como sistemas de control de caudal: atomizadores, temporizadores, en cuartos de baños y cocinas. Por ejemplo: Tomar la decisión de 
        ducharte en lugar de bañarte supone el ahorro de más de 60 litros. ',
        3,
        4
    );

INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Vivir de forma más respetuosa con el medio ambiente',
        'Debes Aplicar la norma 20/80 en tu estilo de vida: El 20% de una acción producirá el 80% de los efectos, mientras que el 80% restante tan sólo originará el 20% de dichos efectos.
        Por tanto, focaliza tu energía hacía aquellas acciones que producen un mayor impacto positivo para el medio ambiente',
        3,
        9
    );

INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Colabora con acciones sociales',
        'Con pequeños gestos puedes beneficiar a infinidad de personas. Plántate colaboraciones con entidades que promuevan acciones con un beneficio socio-ambiental',
        3,
        9
    );

INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Invita a un familiar o amigo a #Ecofriendly',
        'Piensa en local, actua globalmente, mucha gente a la vez haciendo pequeñas cosas pueden generar un gran impacto a nivel mundial, por ello, háblales de #Ecofriendly,
         y conseguiremos un cambio radical en la sociedad',
        3,
        6
    );

INSERT into
    acciones_retos (titulo, descripcion, cat_id, puntaje)
VALUES
    (
        'Un huerto en el balcón',
        '¿Tienes un balcón? Hay soluciones originales y ecológicas como los huertos verticales e hidropónicos (sin tierra, con luz y agua) que permiten cultivar plantas aromáticas, frutas y flores.',
        3,
        6
    );

-- inserto usuarios
INSERT INTO
    usuarios (
        username,
        nombre,
        apellidos,
        email,
        contrasena,
        direccion,
        estado,
        rol,
        fecha_nac
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
        'superadministrador',
        '01/01/2000'
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
        fecha_nac
    )
VALUES
    (
        'alfredo119',
        'Alfredo',
        'Barragán Pedrote',
        'alfredobape@gmail.com',
        crypt('demodemo', gen_salt('bf', 10)),
        'c/ Isabel II Bloque I, 2º A',
        'Estoy luchando por cambiar mis hábitos medio ambientales',
        '01/02/1985'
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
        estado,
        fecha_nac
    )
VALUES
    (
        'rosarito',
        'Rosario',
        'Perez Jiménez',
        'alfredo.barra2gan@iesdonana.org',
        crypt('demodemo', gen_salt('bf', 10)),
        'Cádiz',
        'Puerto Real',
        'C/ Cruz de la Degollada nº 13, 1º b',
        'Me preocupa la situación del cambio climático',
        '01/04/1982'
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
        estado,
        fecha_nac
    )
VALUES
    (
        'eduardocampeon',
        'Eduardo',
        'Eduardo Campeón Llano',
        'eduardo.campeon@iesdonana.org',
        crypt('demodemo', gen_salt('bf', 10)),
        'Rota',
        'Calle de la Luna llena, 12, 2º A ',
        'Estoy loco',
        '05/05/1976'
    );

INSERT INTO
    tipos_notificaciones (id, tipo)
VALUES
    (1, 'comentario');

INSERT INTO
    tipos_notificaciones (id,tipo)
VALUES
    (2, 'me gusta');

INSERT INTO
    tipos_notificaciones (id, tipo)
VALUES
    (3,'seguimiento');