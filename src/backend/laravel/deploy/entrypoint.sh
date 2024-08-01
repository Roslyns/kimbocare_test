#!/bin/bash

# php artisan key:generate
composer dumpautoload
php artisan l5-swagger:generate
php artisan migrate:fresh --seed
# php artisan jwt:secret
php-fpm
