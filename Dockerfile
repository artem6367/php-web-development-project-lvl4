FROM php:8.2-apache

RUN apt update && apt-get install nodejs -y
RUN apt-get install npm -y
RUN apt-get update     && apt-get install -y libpq5 libpq-dev libzip-dev unzip gnupg
RUN docker-php-ext-install pdo pdo_pgsql zip
RUN apt-get update     && apt-get install -y libpq5 libpq-dev libzip-dev unzip gnupg
RUN apt-get install -y postgresql-client
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"     && php composer-setup.php --install-dir=/usr/local/bin --filename=composer     && php -r "unlink('composer-setup.php');"

COPY . .

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN sed -ri -e 's!/var/www/html!${WEBROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${WEBROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN composer install --no-dev
RUN cp -p .env.example .env
RUN npm install
RUN npm run build
RUN chown -R :www-data .
RUN chmod 775 -R storage/
