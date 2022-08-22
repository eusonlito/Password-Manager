[Castellano](readme.es.md)

### Password Manager

This application allows complete password management for multiple types of services (web, ssh, phones, wifi, etc ...).

The data of each application is stored encrypted in the database.

> **The encryption of this data is done using the value of `APP_KEY` as salt, so it is very important not to regenerate this key or you will lose access to all registered applications.**

> **Don't even think about installing this project in an environment without HTTPS protection**

The main features are:

* User Management.
* Team management.
* Access to applications limited by teams.
* Multiple types of data records.
* Encryption in database.
* Authentication by certificate and double factor with Google Authenticator.
* Using certificate, you can to disable password auth.
* Logged every time a user accesses, consults or updates an application.
* Allows private or shared applications.
* Limited access by country.
* It has a chrome extension that connects via API and directly accesses the credentials of the web you are visiting.
* API Password control on every different IP.

This project has an extension for Google Chrome that you can download at https://github.com/eusonlito/Password-Manager-Chrome

### Requirements

- Apache2 (nginx does not support authentication with certificate limited to certain routes)
- PHP 8.0 or higher (php-curl php-imagick php-mbstring php-mysql php-zip)
- MySQL 8.0
- ImageMagick

If PHP 8 is not the default PHP version on your system you must use the binary prefix to exeucte `composer` and `artisan`, for example:

```bash
php8.0 /usr/local/bin/composer install --no-scripts --no-dev
php8.0 /usr/local/bin/composer install --no-dev --optimize-autoloader --classmap-authoritative --ansi
```

```bash
php8.0 artisan key:generate
```

### Installation

#### Docker Compose

1. Clone the repository.
```bash
git clone https://github.com/eusonlito/Password-Manager.git
```

2. Build and pull docker images
```bash
docker-compose pull && docker-compose build

```

3. Adapt Admin credentials in docker-compose.yml


4. Start containers
```bash
docker-compose up

```

5. Open your web browser and goto http://localhost

#### Local Installation

1. Create the database in MySQL.

2. Clone the repository.

```bash
git clone https://github.com/eusonlito/Password-Manager.git
```

3. Install composer dependencies (remember that we always use the PHP 8.0 binary).

```bash
composer install --no-scripts --no-dev && composer install --no-dev --optimize-autoloader --classmap-authoritative --ansi
```

4. Configure the file `.env` with the necessary data.

```bash
cp .env.example .env
```

5. Generate the application key. Remember to backup this key in a secure location (`.env` > `APP_KEY`).

```bash
php artisan key:generate
```

6. Regenerate the caches.

```bash
composer artisan-cache
```

7. Launch the initial migration.

```bash
php artisan migrate
```

8. Launch the seeder.

```bash
php artisan db:seed --class=Database\\Seeders\\Database
```

9. Configure the cron task for the user related to the project:

```
* * * * * cd /var/www/password.domain.com && php artisan schedule:run >> storage/logs/artisan-schedule-run.log 2>&1
```

10. Create the main user.

```bash
php artisan user:create --email=user@domain.com --name=Admin --password=StrongPassword2 --admin
```

11. Configure the server for web access with `DOCUMENT_ROOT` in` public`.

12. Profit!

### Update

The platform update can be done easily with the `composer deploy` command executed by the user who manages that project (usually` www-data`).

This command performs the following actions:

```
"git checkout .",
"git pull",
"@composer env-version --ansi",
"@composer install --no-dev --optimize-autoloader --classmap-authoritative --ansi",
"@php artisan migrate --force --ansi",
"@php ./vendor/bin/php-cs-fixer fix --ansi --quiet",
"@php artisan maintenance:opcache:preload"
```

### Certificate Authentication

In order to authenticate with a certificate, we must add the following configuration in Apache's `VirtualHost`:

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

The `/user/profile/certificate` location allows obtaining the certificate identifier automatically from the user profile itself, and `/user/auth/certificate` is the authentication path by certificate.

The `OptRenegotiate` option allows Apache to independently renegotiate the connection per path, something that nginx does not support.

### Commands

Create User:

```bash
php artisan user:create {--email=} {--name=} {--password=} {--admin} {--readonly} {--teams=}
```

User update:

```bash
php artisan user:update {--id=} {--email=} {--name=} {--password=} {--certificate=} {--tfa_enabled=} {--admin=} {- readonly=} {--enabled=} {--teams=}
```

### Help!

I need help to improve english translations on this project.

Default locale files are located in [`resources/lang/es`](resources/lang/es) and should be translated into [`resources/lang/en`](resources/lang/en).

Also, I need to translate the [English Readme](readme.en.md).

Thanks!

### Screenshots

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
