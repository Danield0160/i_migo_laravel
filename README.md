# Imigo

El nombre de nuestro proyecto es “Imigo”, la “I” viene de “yo” en inglés y “migo” de amigo en español, ya que el objetivo de la aplicación es hacer amigos.

El proyecto trata de crear una herramienta intuitiva para crear eventos sociales y unirte a estos con el objetivo de conocer gente, hacer amigos y/o pasar un rato agradable.

## Guia de instalacion

### windows

1. Descaga el proyecto y descomprimelo
2. Ejecuta en la carpeta `composer install`
3. Pon el fichero ".env" [descargar](https://drive.google.com/file/d/16lBMbBZH95l-OiE8P56tYvGSer8yRjxW/view?usp=sharing)
4. Configura la Base de Datos con el nombre de la Base de datos, de usuario y contraseña especificados
`CREATE DATABASE imigo;`
`CREATE USER 'lv_imigo'@'localhost' IDENTIFIED BY 'Csas1234';`
`GRANT ALL PRIVILEGES ON imigo.* TO 'lv_imigo'@'localhost';`
`FLUSH PRIVILEGES;`
5. Ejecuta `php artisan migrate --seed`
6. Luego ejecuta `php artisan serve` y accede a la pagina


## Documentación
[PROYECTO](https://docs.google.com/document/d/1z4i49N5FAnNWUyvrAS_TqMbDg7_kNeV3pQyYmuOID88/edit#heading=h.6ajru3qaly4h)

## Video Presentación
[Imigo App](https://www.youtube.com/watch?v=T8nl85ynybQ)
