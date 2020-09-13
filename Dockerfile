FROM php:7.4-apache
WORKDIR /var/www/html
ENV APACHE_DOCUMENT_ROOT /var/www/html/web
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN apt-get update && apt-get install -y git libpng-dev wget 
RUN docker-php-ext-install gd > /dev/null
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet
COPY composer.json .
RUN php composer.phar install
RUN rm composer.phar && rm -rf /var/lib/apt/lists/* && apt-get remove -y git wget && apt-get autoremove -y
COPY . .
RUN chown -R www-data:www-data .