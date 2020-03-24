# Instrucciones de instalación y despliegue

## En local

Requisitos:

    PHP 7.3.x
    PostgreSQL.
    Composer.
    Servidor Integrado PHP.
    Una cuenta de correo de gmail.

Pasos:

    Clonar o descargar el proyecto.
    Hacer composer install.
    Cargar las bases de datos, para ello ejecutamos los scripts ./db/create.sh y ./db/load.sh.
    Cambiar el correo electrónico del administrador en config/params.php.
    Crear la variable de entorno STMP_PASS con la clave de aplicación del correo electrónico.
    En el directorio del servicio ejecutar Make Serve, para iniciar el servidor local.

## En la nube

Para la instalación de la aplicación en la nube usaremos Heroku, por lo que una cuénta en dicha plataforma será necesaria para continuar.

Con nuestra cuenta de Heroku, realizaremos los siguientes pasos:

    Con nuestra cuenta de Heroku deberemos crear una aplicación. Además, necesitaremos el comando heroku para consola y poder así con la consola.

    Añadir la extensión para postgres y cargar la base de datos.

Comandos:

heroku login
heroku apps:create nombreAplicacion --region eu
heroku addons:create heroku-postgresql
heroku pg:psql < db/load.sql
heroku pg:psql
create extension pgcrypto;
heroku config:set SMTP_PASS=clave
git push -u heroku master

