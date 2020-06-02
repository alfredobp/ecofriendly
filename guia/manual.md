# Manual de usuario

### Página de inicio sin loguearse
esta es la página de inicio para todos los visitante no logueados. En esta vista tienen las opciones de loguearse, registrarse o recuperar la contraseña. 

![Página de inicio sin loguearse](images/paginicio.png)

Imagen detalle formulario de registro de nuevos usuarios.

![Registro usuario](images/registro.png)

También puede consultar el área de FAQs por si tienen alguna duda sobre el funcionamiento de la red.

![Área de Faqs](images/faqs.png)

### Página de inicio para usuarios logueados primera sesión

Si el usuario es nuevo (primera sesión) debe cumplimentar un cuestionario de valoración de su estilo de vida. Una vez cumplimentado el usuario obtendrá una puntuación de 0 a 100, se le asignará una categoría y en función de esta, unos retos.
![Ecovaloración](images/ecovalora.png)

El usuario debe cumplimentar todos los campos, para enviar el formulario.

![Ecovaloración validación](images/ecovaloraFormulario.png)

Tras la valoración se accede a la pantalla principal de la aplicación (index.html), otorgando los siguientes datos:

![Ecovaloración resultado](images/ecovaloraResultado.png)

![Ecovaloración retos asignados](images/ecovaloraRetos.png)


### Página de inicio para usuarios logueados (Sesión ordinaria)

Esta es la vista principal de la aplicación. EN la barra superior aparece un navbar con las diferentes áreas de la pagína, un buscador y accesos a notificaciones y mensajes, además de la opción de desloguearse.

Por otro lado, el área principal se compone de tres áreas principales:

Un sidebar a la izquierda, con la información del usuario sobre la puntuación obtenida, sus datos de uso así como la gestión de los retos.

En el área central, aparece los feeds propios así como de los usuarios a los que se les sigue. En este área, el usuario puede compartir imagenes, o contenidos.

El siderbar de la derecha refleja la actividad general de la red, con un ranking de puntuación de los usuarios, un listado de participantes y los usuarios a los que se le realiza el seguimiento.

![Pantalla Principal](images/IndexPrincipal.png)

### Área de configuración y estado de la cuenta del usuario.
En esta zona el usuario dispone varias pestañas relativas a la cuenta de usuario:


Perfil del usuario: donde puede configurar datos sobre el perfil, modificar la imagen del avatar, así como datos del perfil y de interacción con la red, tal como el estado o la descripción del usuario.

En esta sesión el usuario puede eliminar la cuenta de usuario, si así lo desea.

![Perfil usuario](images/areausuario.png)

Actividad: en este área el usuario puede ver los feeds compartidos, editarlos, borrarlos o verlos con detalle.

![Actividad en la red](images/areausuario.png)

Actividad: en este área el usuario puede ver los contactos a los que sigues, te sigue, así como los usuarios a los que has bloqueado.

![Actividad en la red](images/usuarios-contactos.png)

Actividad: en este área el usuario puede ver las preferencias de apariencia de la aplicación y puede definir colores, tamaños de texto, ... para distintas áreas del index de la app.

![Actividad en la red](images/usuarios-preferencias.png)

### Área de notificaciones.

En esta zona de contempla las notificaciones de los me gusta, comentarios, y seguimientos que el hacen a la actividad del usuario.

![Notificaciones](images/notificaciones.png)

### Área de Mensajes.

En esta zona de contempla los mensajes de los usuarios, permite enviar, recibir mensajes entre usuarios que se siguen.

![Mensajes](images/mensajes.png)
![Mensajes Recibidos](images/mensaje_recibido.png)
![Mensajes notificación](images/notificacionmensaje.png)
![Mensajes No leido](images/mensajeNoLeido.png)

### Área de FAQs.

Los usuarios pueden visitar en cualquier momento el area de preguntas y respuestas frecuentes.
![Faqs](images/faqs2.png)


### Retos usuarios.

Cuando un usuario se ha valorado se le asigna una categoría, a la que van asociados una serie de retos con una puntuación asignada. Por un lado, el usuario acepta el reto propuesto por el sistema, y cuando ha compliado lo anota como superado. De de forma que se aumenta su puntuación, subiendo de categoría y cambiando los retos propuestos.


![retos](images/retos.png)

![retos](images/retosI.png)

![retos](images/retosII.png)

![retos](images/retosIII.png)

![retos](images/retosIV.png)

![retos](images/retosV.png)

![retos](images/retosVI.png)

![retos](images/retosVII.png)


### Objetivos personales

Los usuarios pueden anotar objetivos personales para indicar más acciones medio ambientales para ser más sostenibles.
![Objetivos Personales](images/objetivospersonalesI.png)
![Objetivos Personales](images/objetivospersonalesIII.png)


### Comentarios

Un usuario puede hacer un comentario en un feed, y también puede borrarlo.

![Comentarios](images/comentarios.png)

### Me gusta

Un usuario puede hacer me gusta y eliminar el me gusta de un feed publicado.

![Me gusta](images/megusta.png)
![No me gusta](images/yanomegusta.png)

### modo admin

El administrador de la plataforma puede realizar las siguientes tareas de administración:

Bloquear cuenta de usuario

![Bloquear/suspender cuenta de usuario](images/modoadminIV.png)
![Bloquear/suspender cuenta de usuario](images/modoadminV.png)


Ver Ranking
El usuario admin puede ver el ranking de todos los usuarios registrados
![ranking](images/modoAdminVI.png)


Ver Acciones Retos

![ecoretos](images/modoadminVII.png)

Listados de Feeds publicados en la red #Ecofriendly

![listadofeeds](images/modoadminVIII.png)


Evolución de los usuarios registrados

![evolucionUsuarios](images/modoadminIX.png)

Gestión de usuarios de la red.
![Gestión Usuarios](images/modoadminX.png)

### Búsqueda
Un usuario puede realizar busquedas de usuarios, hastags o feeds publicados en la red.
![Búsqueda](images/busqueda.png)

### recover y recuperar password
Los usuarios pueden restaurar la contraseña si no la recuerda, para ello el proceso consta de dos partes, Restaurar y reseto de su contraseña. 
Restaurar  Contraseña.
![Recuperar contraseña](images/restaurarPass.png)

Resetear Contraseña.
![Recuperar contraseña](images/resetPass.png)

### iniciar sesión con facebook
Un usuario puede iniciar sesión con facebook (solo operativo en localhost, debido a las limitaciones de la cuenta gratuita de heroku)

![Inicio de sesión con Facebook](images/inicioFacebook.png)