FROM php:5.6-apache

# Enable Apache modules required by .htaccess
RUN a2enmod rewrite headers deflate expires

# Debian Stretch EOL — overwrite sources.list with archive mirror
RUN printf "deb http://archive.debian.org/debian/ stretch main\ndeb http://archive.debian.org/debian-security stretch/updates main\n" \
    > /etc/apt/sources.list && \
    apt-get -o Acquire::Check-Valid-Until=false update && \
    apt-get install -y --allow-unauthenticated zlib1g-dev libzip-dev && \
    rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql zip

# Composer 1.x — last version supporting PHP 5.6
COPY --from=composer:1 /usr/bin/composer /usr/bin/composer

# Allow .htaccess overrides
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# PHP config
RUN echo "date.timezone = Asia/Kolkata" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "log_errors = On" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "error_log = /var/log/apache2/php_errors.log" >> /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs 2>/dev/null || true

RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Railway sets $PORT - Apache must listen on it
RUN echo 'Listen ${PORT}' > /etc/apache2/ports.conf && \
    sed -i 's/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/' /etc/apache2/sites-enabled/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]
