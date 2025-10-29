FROM php:8.2-cli

RUN docker-php-ext-install pdo_mysql

RUN apt-get update

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

CMD ["php", "index.php"]