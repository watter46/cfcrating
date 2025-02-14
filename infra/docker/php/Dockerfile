FROM php:8.3-fpm-bullseye AS base

SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]
WORKDIR /var/www/src

# timezone environment
ENV TZ=UTC \
  # locale
  LANG=en_US.UTF-8 \
  LANGUAGE=en_US:en \
  LC_ALL=en_US.UTF-8 \
  # composer environment
  COMPOSER_HOME=/composer

FROM composer:2.7.8 as composer

FROM node:20.17.0-bullseye-slim as node

ARG UID=1000
ARG GID=1000

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=node /usr/local/bin /usr/local/bin
COPY --from=node /usr/local/lib/node_modules/npm /usr/local/lib/node_modules/npm

# hadolint ignore=DL3008
RUN <<EOF
  apt-get update
  apt-get -y install --no-install-recommends \
    locales \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    default-mysql-client
  locale-gen en_US.UTF-8
  localedef -f UTF-8 -i en_US en_US.UTF-8 \
  docker-php-ext-configure gd --with-freetype --with-jpeg=/usr/include/ \
  docker-php-ext-install \
    intl \
    pdo_mysql \
    zip \
    bcmath \
    gd
  # permission denied bind mount in Linux environment
  groupadd --gid $GID $USER_NAME
  useradd --uid $UID --gid $GID $USER_NAME
  chown $USER_NAME:$USER_NAME /composer
  chown $USER_NAME:$USER_NAME /var/www
  apt-get clean
  rm -rf /var/lib/apt/lists/*
EOF

FROM base AS local

COPY ./infra/docker/php/php.local.ini /usr/local/etc/php/php.ini

USER $USER_NAME

FROM base AS production
COPY ./infra/docker/php/php.ini /usr/local/etc/php/php.ini
COPY --chown=$USER_NAME:$USER_NAME ./src /var/www/src/

USER $USER_NAME