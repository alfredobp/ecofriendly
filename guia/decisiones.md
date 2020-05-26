# Decisiones adoptadas

Modifico el elemento de innovación, para sustituir el uso de la plantilla por amazon web services, como medio de almacenamiento de las imagenes.

En el el caso del requisito **([R90](https://github.com/alfredobp/ecofriendly/issues/90)) Acceder mediante perfil de facebook** ha sido descartado debido a las limitaciones de esta red social para aprobar su acceso a la API. En concreto, era necesario un certificado SSL, que la versión gratuita de Heroku no permite, además de una política de condiciones para el usuario validada por el equipo técnico. En local, funcionaba de forma correcta, tomando el email del usuario facebook y realizando el login.