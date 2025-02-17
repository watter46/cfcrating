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

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

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

# Local
FROM base AS local

ENV APP_ENV=local

COPY ./infra/docker/php/php.local.ini /usr/local/etc/php/php.ini
COPY --from=node /usr/local/bin /usr/local/bin
COPY --from=node /usr/local/lib/node_modules/npm /usr/local/lib/node_modules/npm

# RUN <<EOF
#   chown -R $USER_NAME:$GROUP_NAME /var/www/
#   chmod +x /var/www/
# EOF

USER $USER_NAME

# Production node builder
FROM node AS builder

COPY ./src /var/www/src/

RUN <<EOF
  npm ci
  npm run build
EOF

# Production
FROM base AS production

ENV APP_ENV=production

COPY ./infra/docker/php/php.ini /usr/local/etc/php/php.ini
COPY --from=builder /var/www/src/public/build /var/www/src/public
COPY ./src /var/www/src/

RUN <<EOF
  mkdir -p /var/www/src/vendor
  chown -R $USER_NAME:$USER_NAME /var/www/src
EOF

USER $USER_NAME

RUN <<EOF
  composer install --quiet --no-interaction --no-ansi --no-dev --no-scripts --no-progress --prefer-dist
  composer dump-autoload --optimize
  chmod -R 775 storage bootstrap/cache
  php artisan optimize:clear
  php artisan optimize
EOF