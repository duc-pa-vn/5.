FROM php:7.3-fpm-alpine
# install mysql pdo driver
RUN docker-php-ext-install pdo_mysql

# composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
