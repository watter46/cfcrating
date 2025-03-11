# ====================================
# base
# ====================================
FROM php:8.3-fpm-alpine AS base

# timezone environment
ENV TZ=UTC \
  # locale
  LANG=en_US.UTF-8 \
  LANGUAGE=en_US:en \
  LC_ALL=en_US.UTF-8

ARG USER_NAME ${USER_NAME}
ARG UID ${UID}
ARG GID ${GID}

RUN apk add --no-cache bash

RUN addgroup -g $GID $USER_NAME && \
    adduser -s /bin/bash -D -u $UID -G $USER_NAME $USER_NAME

# ====================================
# local
# ====================================
FROM node:lts-alpine AS node

FROM base AS local

WORKDIR /var/www/src

RUN apk add --no-cache \
        oniguruma-dev \
        libxml2-dev \
        libzip-dev \
        libpng-dev \
        freetype-dev \
        libjpeg-turbo-dev \
        git \
        vim

RUN docker-php-ext-configure gd \
        --with-freetype=/usr/include/ \
        --with-jpeg=/usr/include/ && \
    docker-php-ext-install \
    pdo_mysql \
    zip \
    bcmath \
    gd

COPY ./infra/docker/php/php.local.ini /usr/local/etc/php/php.ini
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer
COPY --from=node /usr/local/bin /usr/local/bin
COPY --from=node /usr/local/lib/node_modules/npm /usr/local/lib/node_modules/npm

RUN chown -R $USER_NAME:$USER_NAME /var/www/src

USER $USER_NAME

# ====================================
# production
# ====================================
# Production node builder
FROM node AS assets
WORKDIR /var/www/src

COPY src/package.json src/package-lock.json ./
RUN npm ci

COPY ./src/ ./
RUN npm run build


FROM composer:2.7 AS vendor
WORKDIR /app

COPY ./src .

RUN composer install --prefer-dist --no-dev --optimize-autoloader


FROM base AS production

WORKDIR /var/www/src

RUN apk add --no-cache \
        oniguruma \
        libxml2 \
        libzip-dev \
        libpng-dev \
        freetype-dev \
        libjpeg-turbo-dev

RUN docker-php-ext-configure gd \
        --with-freetype=/usr/include/ \
        --with-jpeg=/usr/include/ && \
    docker-php-ext-install \
    pdo_mysql \
    zip \
    bcmath \
    gd

COPY ./infra/docker/php/php.ini /usr/local/etc/php/php.ini
COPY ./src/ ./
COPY --from=vendor /app/vendor /var/www/src/vendor/
COPY --from=assets /var/www/src/public/build /var/www/src/public/build

RUN chmod -R 775 storage bootstrap/cache && \
    chown -R $USER_NAME:$USER_NAME /var/www

USER $USER_NAME