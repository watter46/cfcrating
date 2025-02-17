FROM nginx:1.27 AS base

SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]
WORKDIR /var/www/src

ENV TZ=UTC

RUN <<EOF
  groupmod -g 1000 nginx
  usermod -u 1000 nginx
  chown -R nginx:nginx /var/cache/nginx/ \
        /var/run/ \
        /var/log/nginx/
EOF

FROM base AS local

ENV APP_ENV=local

COPY ./infra/docker/nginx/default.local.conf /etc/nginx/conf.d/default.conf

FROM base AS production

ENV APP_ENV=production

COPY ./infra/docker/nginx/default.conf /etc/nginx/conf.d/default.conf