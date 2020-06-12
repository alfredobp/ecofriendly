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
    Ejecutar en la terminal el comando composer install para descargar las dependencias necesarias (Vendor).
    Cargar la esturctura e información de las  bases de datos, para ello ejecutamos los scripts ./db/create.sh y ./db/load.sh.
    Cambiar el correo electrónico del administrador en config/params.php.
    Crear la variable de entorno STMP_PASS con la clave de aplicación del correo electrónico, así como las de AWS para habilitar la subida de imagenes.
    En el directorio del servicio ejecutar Make Serve, para iniciar el servidor local.

## En la nube

Para la instalación de la aplicación en la nube utilizaremos la aplicación Heroku, por lo que será necesaria una cuénta en dicha plataforma para continuar.

Con nuestra cuenta de Heroku, realizaremos los siguientes pasos:

    Logueados en nuestra cuenta de Heroku deberemos crear una nueva aplicación. Además, necesitaremos el comando heroku para consola y poder así cargar la base de datos en remoto y los archivos.

    Añadir la extensión para postgres y cargar la base de datos.

Comandos:

    heroku login
    heroku apps:create nombreAplicacion --region eu
    heroku addons:create heroku-postgresql
    heroku pg:psql < db/load.sql --app
    heroku pg:psql
    create extension pgcrypto;
    heroku config:set SMTP_PASS=clave
    git push -u heroku master

