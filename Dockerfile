FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN rm -f /etc/apache2/mods-enabled/mpm_event.conf \
    /etc/apache2/mods-enabled/mpm_event.load

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]