# Documentation du Projet kimbo_test backend (laravel)

## Introduction

Ce document fournit des instructions pour configurer, développer et lancer une application Laravel. Suivez les étapes ci-dessous pour mettre en place votre environnement de développement et démarrer votre projet.

## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :

- [Composer](https://getcomposer.org/) (pour la gestion des dépendances PHP)
- [PHP](https://www.php.net/) (version recommandée : PHP 8.1 ou supérieure)
- [MySQL](https://www.mysql.com/) ou une autre base de données compatible (si nécessaire)

## Création du Projet Laravel

1. **Ouvrez un Terminal ou Invite de Commande**.

2. **Créez un Nouveau Projet Laravel** :

   ```sh
   composer create-project --prefer-dist laravel/laravel laravel
   ```

   Ici `laravel` est le nom souhaité pour notre projet Laravel.

3. **Accédez au Répertoire du Projet** :

   ```sh
   cd src/backend/laravel
   ```

## Configuration de l'Environnement

1. **Copiez le Fichier `.env.example` en `.env`** :

   ```sh
   cp .env.example .env
   ```

2. **Générez la Clé d'Application** :

   ```sh
   php artisan key:generate
   ```

3. **Configurez la Base de Données** :

   Modifiez le fichier `.env` pour inclure les informations de votre base de données, par exemple :

   ```env
    DB_CONNECTION=mysql
    DB_HOST=db_kimbo_test
    DB_PORT=3306
    DB_DATABASE=kimbotest_db
    DB_USERNAME=userKimboTest
    DB_PASSWORD="oi*Kjhf782^sakjsksHJHJHJdjs**#7623jsd%$*hjs._HJHS"

    # for mysql container
    MYSQL_DATABASE="${DB_DATABASE}"
    MYSQL_USER="${DB_USERNAME}"
    MYSQL_PASSWORD="${DB_PASSWORD}"
    MYSQL_ROOT_PASSWORD="${DB_PASSWORD}"

    # for phpmyadmin container
    PMA_HOST="${DB_HOST}"
    PMA_PORT="${DB_PORT}"
   ```

## Commandes de Base

Voici quelques commandes de base que vous pouvez utiliser avec Laravel :

- **Générer une Clé d'Application** :

  ```sh
  php artisan key:generate
  ```

- **Générer une doc swagger pour l'Application** :
  ```sh
  php artisan l5-swagger:generate
  ```

- **Générer un secret jwt** :

  ```sh
  php artisan jwt:secret
  ```

- **Exécuter les Migrations** :

  ```sh
  php artisan migrate:fresh --seed
  ```

- **Lancer le Serveur de Développement** :

  ```sh
  php artisan serve
  ```

  Par défaut, l'application sera accessible à l'adresse [http://localhost:8001](http://localhost:8001).


## Déploiement

Pour déployer votre application Laravel avec Docker et Docker Compose, suivez les étapes ci-dessous. Docker vous permet d'encapsuler votre application et ses dépendances dans des conteneurs, ce qui facilite la gestion et le déploiement de votre application dans différents environnements.

### Prérequis

Assurez-vous que Docker et Docker Compose sont installés sur votre machine. Vous pouvez les télécharger depuis [le site officiel de Docker](https://www.docker.com/products/docker-desktop).

### Fichiers de Configuration

1. **Créez un fichier `Dockerfile`** à la racine de votre projet Laravel :

   ```Dockerfile
   # 1. stage: dependencies installation
   FROM php:8.1-fpm as dependencies

   WORKDIR /var/www
   COPY composer.* ./
   RUN apt-get update && apt-get install -y \
      libpng-dev \
      libjpeg-dev \
      libfreetype6-dev \
      libzip-dev \
      unzip \
      libonig-dev \
      libxml2-dev \
      libcurl4-openssl-dev \
      git \
      curl \
      && docker-php-ext-configure gd --with-freetype --with-jpeg \
      && docker-php-ext-install gd zip pdo pdo_mysql \
      && docker-php-ext-install opcache \
      && apt-get clean && rm -rf /var/lib/apt/lists/*
   RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
   COPY . .


   # 2. stage: application setup
   FROM php:8.1-fpm as application

   WORKDIR /var/www
   COPY --from=dependencies /var/www /var/www
   COPY --from=dependencies /usr/local /usr/local
   COPY deploy/entrypoint.sh /usr/local/bin/entrypoint.sh
   RUN groupadd -g 1000 www
   RUN useradd -u 1000 -ms /bin/bash -g www www
   RUN chown -R www:www /var/www/storage /var/www/bootstrap/cache /var/www/vendor/composer/
   # /var/www/vendor
   USER www
   EXPOSE 9000
   ENTRYPOINT ["entrypoint.sh"]

   ```
- **Ici vous avez le contenu du fichier entrypoint.sh** :

   ```sh
   #!/bin/bash

   php artisan key:generate
   composer dumpautoload
   php artisan l5-swagger:generate
   php artisan migrate:fresh --seed
   php artisan jwt:secret
   php-fpm
   ```
- **Documentation swagger** :

   ```sh
   http://localhost:8001/api/documentation
   ```