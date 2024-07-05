FROM php:8.3-fpm

ARG UGROUP=1000
ARG MYSQL_CLIENT="mysql-client"


RUN apt-get update && apt-get install -y nano zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

COPY xdebug/90-xdebug.ini "${PHP_INI_DIR}/conf.d"
RUN pecl config-set php_ini "${PHP_INI_DIR}/php.ini"
RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version
RUN cd ~

RUN curl -sL https://deb.nodesource.com/setup_20.x | bash
RUN apt-get install --yes nodejs

RUN apt-get update \
    && npm install -g npm \
    && npm install -g pnpm \
    && npm install -g bun \
    && apt-get update \
    && apt-get install -y default-mysql-client \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN usermod -u 1000 www-data

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN echo 'alias sf="php bin/console"' >> ~/.bashrc

WORKDIR /var/www/html