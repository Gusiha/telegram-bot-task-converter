FROM php:8.2-cli

RUN docker-php-ext-install pdo_mysql

RUN apt-get update && apt-get install -y \
                       git \
                       unzip \
                       zip

#RUN pecl install xdebug && docker-php-ext-enable xdebug


COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN echo 'alias phpunit="vendor/bin/phpunit"' >> ~/.bashrc