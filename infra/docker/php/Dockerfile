FROM php:8.3-fpm-bullseye AS base

WORKDIR /var/www/src

# timezone environment
ENV TZ=UTC \
  # locale
  LANG=en_US.UTF-8 \
  LANGUAGE=en_US:en \
  LC_ALL=en_US.UTF-8 \
  # composer environment
  COMPOSER_HOME=/composer

ARG USER_NAME ${USER_NAME}
ARG UID ${UID}
ARG GID ${GID}

# hadolint ignore=DL3008
RUN <<EOF
  apt-get update
  apt-get -y install --no-install-recommends \
    locales \
    unzip \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    default-mysql-client
  locale-gen en_US.UTF-8
  localedef -f UTF-8 -i en_US en_US.UTF-8
  docker-php-ext-configure gd --with-freetype --with-jpeg=/usr/include/
  docker-php-ext-install \
    intl \
    pdo_mysql \
    zip \
    bcmath \
    gd
  # permission denied bind mount in Linux environment
  groupadd --gid $GID $USER_NAME
  useradd -m --uid $UID --gid $GID $USER_NAME
  chown $USER_NAME:$USER_NAME /composer
  chown $USER_NAME:$USER_NAME /var/www
  apt-get clean
  rm -rf /var/lib/apt/lists/*
EOF

# node base
FROM node:lts-bullseye-slim AS node

WORKDIR /var/www/src

# Local
FROM base AS local

ENV APP_ENV=local

COPY ./infra/docker/php/php.local.ini /usr/local/etc/php/php.ini
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer
COPY --from=node /usr/local/bin /usr/local/bin
COPY --from=node /usr/local/lib/node_modules/npm /usr/local/lib/node_modules/npm

USER $USER_NAME

# Production node builder
FROM node AS node-builder
WORKDIR /var/www/src

COPY src/package.json src/package-lock.json ./
RUN npm ci

COPY ./src/ ./
RUN npm run build

# Production composer builder
FROM composer:2.7 AS composer-builder
WORKDIR /app

COPY ./src .

RUN composer install --prefer-dist --no-dev --optimize-autoloader

# Production
FROM base AS production

ENV APP_ENV=production

# copy production dockerignore
COPY ./infra/docker/php/php.ini /usr/local/etc/php/php.ini
COPY ./src/ ./
COPY --from=composer-builder /app/vendor /var/www/src/vendor/
COPY --from=node-builder /var/www/src/public/build /var/www/src/public/build

RUN <<EOF
  php artisan config:cache
  php artisan event:cache
  php artisan route:cache
  php artisan view:cache
  chmod -R 775 storage bootstrap/cache
  chown -R $USER_NAME:$USER_NAME /var/www
EOF

USER $USER_NAME