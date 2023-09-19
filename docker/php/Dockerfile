FROM php:8.1-fpm

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip libpq-dev cron vim nano procps \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install intl opcache pdo pdo_pgsql pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-install mysqli \
    && docker-php-ext-enable mysqli

#Install xdebug
# RUN apt-get update && apt-get install -y wget git unzip \
# 	&& pecl install xdebug-3.1.3 \
# 	&& docker-php-ext-enable xdebug

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#Configure permissions
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data && \
	chsh -s /bin/bash www-data

RUN find /var/www/html -type d -exec chmod 755 {} \;
RUN	find /var/www/html -type f -exec chmod 644 {} \;

RUN echo "www-data:www-data" | chpasswd
RUN usermod -aG sudo www-data

USER www-data