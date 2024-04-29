# Imigo

El nombre de nuestro proyecto es “Imigo”, la “I” viene de “yo” en inglés y “migo” de amigo en español, ya que el objetivo de la aplicación es hacer amigos.

El proyecto trata de crear una herramienta intuitiva para crear eventos sociales y unirte a estos con el objetivo de conocer gente, hacer amigos y/o pasar un rato agradable.


## Guia de instalacion

### windows

1. Descaga el proyecto y descomprimelo
2. Ejecuta en la carpeta `composer install`
3. Pon el fichero ".env"
4. Configura la Base de Datos con el nombre de la Base de datos, de usuario y contraseña especificados
`CREATE DATABASE imigo;`
`CREATE USER 'lv_imigo'@'localhost' IDENTIFIED BY 'Csas1234';`
`GRANT ALL PRIVILEGES ON imigo.* TO 'lv_imigo'@'localhost';`
`FLUSH PRIVILEGES;`
5. luego ejecuta `php artisan serve` y accede a la pagina


### Linux

## Documentación
[PROYECTO.pdf](https://github.com/faridibal/Waste-Watch/files/11482304/PROYECTO.pdf)

## Video Presentación
[Imigo App](https://www.youtube.com/watch?v=T8nl85ynybQ)