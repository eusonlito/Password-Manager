[English](readme.md)

### Gestor de Contraseñas

Esta aplicación permite una gestión completa de contraseñas para múltiples tipos de servicios (web, ssh, teléfonos, wifi, etc...).

Los datos de cada aplicación se guardan cifrados en base de datos.

> **El cifrado de estos datos se realiza usando el valor de `APP_KEY` como salt, con lo cual es importantísimo no regenerar esta key o perderás el acceso a todas las aplicaciones registradas.**

> **Ni se te ocurra instalar este proyecto en un entorno sin protección HTTPS**

Las características principales son:

* Gestión de usuarios.
* Gestión de equipos.
* Acceso a aplicaciones limitadas por equipos.
* Múltiples tipos de datos a registrar.
* Cifrado en base de datos.
* Autenticación por certificado y doble factor con Google Authenticator.
* Usando certificado puedes desactivar el acceso por contraseña.
* Dispone de un log que registra cada vez que algún usuario accede, consulta o actualiza una aplicación.
* Permite aplicaciones privadas o compartidas.
* Limitación de acceso por país.
* Dispone de una extensión de chrome que se conecta vía API y accede directamenete a las credenciales de la web que estás visitando.
* Solicitud de contraseña de API cada vez que se accede desde una IP diferente.

Este proyecto dispone de una extensión para Google Chrome que puedes descargar en https://github.com/eusonlito/Password-Manager-Chrome

### Requisitos

- Apache2 (nginx no soporta autenticación con certificado limitado a ciertas rutas)
- PHP 8.1 o superior (php-curl php-imagick php-mbstring php-mysql php-zip)
- MySQL 8.0
- ImageMagick

Si la versión por defecto de tu servidor es inferior a PHP 8.1 siempre debes usar el prefijo de versión, tanto para `composer` como para `artisan`, por ejemplo:

```bash
php8.1 ./composer install --no-dev --optimize-autoloader --classmap-authoritative --ansi
```

```bash
php8.1 artisan key:generate
```

### Instalación Local

1. Creamos la base de datos en MySQL.

2. Clonamos el repositorio.

```bash
git clone https://github.com/eusonlito/Password-Manager.git
```

3. Copia el fichero `.env.example` como `.env` y rellena las variables necesarias.

```bash
cp .env.example .env
```

4. Realizamos la primera instalación (recuerda que siempre usando el binario de PHP 8.1).

```bash
./composer install --no-dev --optimize-autoloader --classmap-authoritative --ansi
```

5. Generamos la clave de aplicación. Recuerda guardar una copia de seguridad de esta clave (`.env` > `APP_KEY`).

```bash
php artisan key:generate
```

6. Regeneramos las cachés.

```bash
./composer artisan-cache
```

7. Lanzamos la migración inicial.

```bash
php artisan migrate
```

8. Lanzamos el seeder.

```bash
php artisan db:seed --class=Database\\Seeders\\Database
```

9. Configuramos la tarea cron para el usuario relacionado con el proyecto:

```
* * * * * cd /var/www/password.domain.com && php artisan schedule:run >> storage/logs/artisan-schedule-run.log 2>&1
```

10. Creamos el usuario principal.

```bash
php artisan user:create --email=user@domain.com --name=Admin --password=StrongPassword2 --admin
```

11. Configuramos el servidor para acceso web con `DOCUMENT_ROOT` en `public`.

12. Profit!

#### Actualización

La actualización de la plataforma se puede realizar de manera sencilla con el comando `composer deploy` ejecutado por el usuario que gestiona ese projecto (normalmente `www-data`).

### Instalación vía Docker

Actualmente debería ser usado únicamente para testing (no soporta autenticación con certificado).

1. Clonamos el repositorio.

```bash
git clone https://github.com/eusonlito/Password-Manager.git
```

2. [OPCIONAL] Copia el fichero `docker/.env.example` en `.env` y configura tus propios ajustes

```bash
cp docker/.env.example .env
```

3. [OPCIONAL] Copia el fichero `docker/docker-compose.yml.example` en `docker/docker-compose.yml` y configura tus propios ajustes

```bash
cp docker/docker-compose.yml.example docker/docker-compose.yml
```

4. Realizamos el build (pedirá la contraseña de sudo)

```bash
./docker/build.sh
```

5. Iniciamos los contenedores (pedirá la contraseña de sudo)

```bash
./docker/run.sh
```

6. Creamos el usuario principal (pedirá la contraseña de sudo)

```bash
./docker/user.sh
```

7. Ya podemos acceder desde http://localhost:8080

8. Recuerda añadir un servidor web (apache2, nginx, etc...) como proxy para añadir funcionalidades como SSL.

#### Actualización

1. Actualizamos el código del proyecto

```bash
git pull
```

2. Realizamos el build (pedirá la contraseña de sudo)

```bash
./docker/build.sh
```

3. Iniciamos los contenedores (pedirá la contraseña de sudo)

```bash
./docker/run.sh
```

4. Ya podemos acceder desde http://localhost:8080

### Autenticación con Certificado

Para poder realizar la autenticación con certificado debemos añadir la siguiente configuración en el `VirtualHost` de Apache:

```
<Location /user/profile/certificate>
        SSLVerifyClient require
        SSLVerifyDepth 2
        SSLOptions +StdEnvVars +ExportCertData +OptRenegotiate
</Location>

<Location /user/auth/certificate>
        SSLVerifyClient require
        SSLVerifyDepth 2
        SSLOptions +StdEnvVars +ExportCertData +OptRenegotiate
</Location>

SSLCACertificateFile /var/www/password.domain.com/resources/certificates/certificates.pem
```

La localización `/user/profile/certificate` permite obtener el identificador del certificado automáticamente desde el propio perfil de usuario, y `/user/auth/certificate` es la ruta de autenticación por certificado.

La opción de `OptRenegotiate` le permite a Apache renegociar la conexión de manera independiente por ruta, algo que nginx no soporta.

### Comandos

Alta de usuario:

```bash
php artisan user:create {--email=} {--name=} {--password=} {--admin} {--readonly} {--teams=}
```

Actualización de usuario:

```bash
php artisan user:update {--id=} {--email=} {--name=} {--password=} {--certificate=} {--tfa_enabled=} {--admin=} {--readonly=} {--enabled=} {--teams=}
```

### Ayuda!

Pues estaría guay un poco de ayuda para mejorar la traducción a inglés en [`resources/lang/en`](resources/lang/en), así como el [`readme.en.md`](readme.en.md).

### Capturas

![Password-Manager](https://user-images.githubusercontent.com/644551/128019854-2d313657-29ec-48e8-bb8e-9802eb05858f.png)

![Password-Manager](https://user-images.githubusercontent.com/644551/128019842-4ea81ac4-a8c3-405a-92d5-d174b5997b93.png)

![Password-Manager](https://user-images.githubusercontent.com/644551/128019852-94612c82-03a3-4328-91d7-0c1c918056aa.png)

![Password-Manager](https://user-images.githubusercontent.com/644551/128019851-1b6f845a-c5cf-4870-b056-d86c1b9d46e2.png)

![Password-Manager](https://user-images.githubusercontent.com/644551/128019849-c63330dc-0c19-4ea6-90fe-c519c5b91091.png)

![Password-Manager](https://user-images.githubusercontent.com/644551/128019846-f44500b9-302b-47e6-91df-afe8918c732d.png)

![Password-Manager](https://user-images.githubusercontent.com/644551/128019845-03d88565-71e1-4cff-85a4-5c41042c72d6.png)

![Password-Manager](https://user-images.githubusercontent.com/644551/128019834-9ac49dbc-fcab-4129-aeea-8ca0906c99db.png)

![Password-Manager](https://user-images.githubusercontent.com/644551/128019829-8015cb2e-db1a-4100-8a0d-088e5e17411a.png)

![Password-Manager](https://user-images.githubusercontent.com/644551/128019826-dc34723b-e446-4541-b14c-36d7b4b81e16.png)

![Password-Manager](https://user-images.githubusercontent.com/644551/128019838-9bad81b4-1e9b-4591-a8c1-44193130a117.png)

![Password-Manager](https://user-images.githubusercontent.com/644551/128019844-f74e3b26-57fa-48b9-8849-0410f8e0b99b.png)
