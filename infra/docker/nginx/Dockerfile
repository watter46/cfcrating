# ====================================
# base
# ====================================
FROM nginx:1.27 AS base

SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]
WORKDIR /var/www/src

ENV TZ=UTC

ARG UID ${UID}
ARG GID ${GID}

COPY ./src/public /var/www/src/public

RUN <<EOF
  groupmod -g $GID nginx
  usermod -u $UID nginx
  chown -R nginx:nginx /var/cache/nginx/ \
    /var/run/ \
    /var/log/nginx/ \
    /var/www/src
EOF

# ====================================
# local
# ====================================
FROM base AS local

COPY ./infra/docker/nginx/default.local.conf /etc/nginx/conf.d/default.conf
COPY ./infra/docker/nginx/nginx.local.conf /etc/nginx/nginx.conf

USER nginx

# ====================================
# production
# ====================================
FROM base AS production

COPY ./infra/docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY ./infra/docker/nginx/nginx.conf /etc/nginx/nginx.conf

USER nginx

# ====================================
# staging
# ====================================
FROM base AS staging

COPY ./infra/docker/nginx/default.staging.conf /etc/nginx/conf.d/default.conf
COPY ./infra/docker/nginx/nginx.staging.conf /etc/nginx/nginx.conf

USER nginx