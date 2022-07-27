FROM php:8.1.2-fpm

ARG user
ARG uid

RUN apt update && apt upgrade -y && apt install -y \
    git \
    libzip-dev \
    zip \
    unzip \
    tzdata

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install zip

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

RUN useradd -G www-data,root -u $uid -d /home/$user $user

RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

RUN ln -fs /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime && \
    dpkg-reconfigure -f noninteractive tzdata

ENV TZ="America/Sao_Paulo"

WORKDIR /var/www