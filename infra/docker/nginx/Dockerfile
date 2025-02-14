FROM nginx:1.27 as base

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

FROM base as local

COPY ./infra/docker/nginx/default.local.conf /etc/nginx/conf.d/

FROM base as production

COPY ./infra/docker/nginx/default.conf /etc/nginx/conf.d/

FROM nginx:1.27

SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]
WORKDIR /var/www/src

ENV TZ=UTC

COPY ./infra/docker/nginx/*.conf /etc/nginx/conf.d/
