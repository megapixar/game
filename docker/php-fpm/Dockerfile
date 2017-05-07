FROM php:7.0-fpm

COPY ./php.ini /usr/local/etc/php/conf.d/

RUN usermod -u 1000 www-data

RUN apt-get update

RUN chown -R www-data:www-data /tmp

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# Install phpunit
RUN curl -LsS https://phar.phpunit.de/phpunit.phar -o /usr/local/bin/phpunit \
    && chmod a+x /usr/local/bin/phpunit \
    && phpunit --version

RUN apt-get install -y \
        libssl-dev \
        git\
        zip

RUN apt-get install -y zlib1g-dev libicu-dev g++
RUN docker-php-ext-install intl
RUN docker-php-ext-configure intl
RUN docker-php-ext-install opcache
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install zip

RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

CMD ["php-fpm", "-F"]

EXPOSE 9000
