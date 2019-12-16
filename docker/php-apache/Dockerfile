FROM php:7.2-apache

RUN apt update; apt install git postgresql-client postgresql-server-dev-11 locales \
    libfreetype6-dev libjpeg62-turbo-dev libpng-dev libmcrypt-dev unzip -y

RUN docker-php-ext-install mbstring pdo pdo_pgsql gd iconv

# composerをインストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

# rewrite headersを有効化
RUN a2enmod rewrite headers
