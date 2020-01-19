# Diccionario Personal
Herramienta web (CRUD) diseñada para almacenar palabras con sus respectivos significados, repartiendo dichas palabras en distintos grupos para una consulta más eficiente de los mismos. El usuario podrá listar y modificar, tanto sus palabras como sus grupos creados, para una mejor gestión. 
La herramienta posee un sistema de login, así como la posibilidad de solicitar una nueva contraseña y recibirla en el correo electrónico.
## Requisitos previos 
Es necesario tener instalado un servidor local para poder trabajar con los archivos del repositorio descargado o clonado. Yo utilizo [XAMPP:](https://www.apachefriends.org/es/index.html).
## Uso del programa
Lo primero será crear la base de datos, en la carpeta 'mysql' hay una plantilla de la base que he utilizado. En 'baseDeDatos' está el archivo 'Ejemplo.datosBaseDeDatos.php', en 'include' el archivo 'Ejemplo.enviarNuevaContra.php' y en la raíz se encuentra 'Ejemplo.politicaDePrivacidad.php'; estos tres archivos habrá que rellenarlos con los datos necesarios y renombrarlos, suprimiendo para ello la palabra 'Ejemplo' del nombre. Con esto ya se puede poner el programa en marcha.     
## Funcionalidades de otros proyectos
* Para hacer uso del servidor de correo electrónico he utilizado la clase del proyecto PHPMailer, disponible para descargar en su [repositorio](https://github.com/PHPMailer/PHPMailer).
* Para el aviso de cookies he empleado el proyecto Bootstrap-Cookie-Alert, el cual puedes ver en su [repositorio](https://github.com/Wruczek/Bootstrap-Cookie-Alert).
## Tecnologías utilizadas
* HTML.
* CSS.
* Bootstrap 4.
* Javascript.
* PHP.
* MySQL.
