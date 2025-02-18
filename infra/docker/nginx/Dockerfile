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

FROM base AS local

ENV APP_ENV=local

COPY ./infra/docker/nginx/default.local.conf /etc/nginx/conf.d/default.conf


FROM base AS production

ENV APP_ENV=production

COPY ./infra/docker/nginx/default.conf /etc/nginx/conf.d/default.conf

USER nginx