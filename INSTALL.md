# Installation


### Database creation

Login as root
```sh
mysql -u root -p
```

Change with your data

```sql
CREATE USER 'nombre_usuario'@'localhost' IDENTIFIED BY 'tu_contrasena';
CREATE DATABASE database_name
GRANT ALL PRIVILEGES ON database_name.* TO 'nombre_usuario'@'localhost';
```

### 3rd party libraries

*Install composer before from package manager or manually  then type:
```sh
composer install
```

### Add your data to parameters.yml file
Only if composer haven't asked

```sh
app/config/parameters.yml
```

### Logs and cache directory permissions.

```sh
rm -rf app/cache/*
rm -rf app/logs/*
HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
```

### Create database schema

```sh
php app/console doctrine:schema:create
```

### Create superuser
Change with your data and strong password
```sh
php app/console fos:user:create testuser test@example.com p@ssword
php app/console fos:user:promote testuser ROLE_SUPER_ADMIN
```

### Nginx Server block config

change root, server name, fastcgi_pass, error_log and access_log.

```
server {
    server_name domain.tld www.domain.tld;
    root /var/www/project/web;

    location / {
        # try to serve file directly, fallback to app.php
        try_files $uri /app.php$is_args$args;
    }
    # DEV
    # This rule should only be placed on your development environment
    # In production, don't include this and don't deploy app_dev.php or config.php
    location ~ ^/(app_dev|config)\.php(/|$) {
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        # When you are using symlinks to link the document root to the
        # current version of your application, you should pass the real
        # application path instead of the path to the symlink to PHP
        # FPM.
        # Otherwise, PHP's OPcache may not properly detect changes to
        # your PHP files (see https://github.com/zendtech/ZendOptimizerPlus/issues/126
        # for more information).
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
    }
    # PROD
    location ~ ^/app\.php(/|$) {
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        # When you are using symlinks to link the document root to the
        # current version of your application, you should pass the real
        # application path instead of the path to the symlink to PHP
        # FPM.
        # Otherwise, PHP's OPcache may not properly detect changes to
        # your PHP files (see https://github.com/zendtech/ZendOptimizerPlus/issues/126
        # for more information).
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
        # Prevents URIs that include the front controller. This will 404:
        # http://domain.tld/app.php/some-path
        # Remove the internal directive to allow URIs like this
        internal;
    }

    # return 404 for all other php files not matching the front controller
    # this prevents access to other php files you don't want to be accessible.
    location ~ \.php$ {
      return 404;
    }

    error_log /var/log/nginx/project_error.log;
    access_log /var/log/nginx/project_access.log;
}

```

Then paste and link.
```sh
sudo nano /etc/nginx/sites-available/nuevo-sitio
sudo ln -s /etc/nginx/sites-available/nuevo-sitio /etc/nginx/sites-enabled/nuevo-sitio
```

In dev environment add domain to your host file.

```sh
/etc/hosts
```
In production create a A record

### Reload nginx config
```sh
sudo systemctl reload nginx
```

### Install assets
```sh
php app/console assetic:dump --env=prod --no-debug
php app/console assets:install --symlink web
```
