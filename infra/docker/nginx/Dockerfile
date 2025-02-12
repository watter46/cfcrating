FROM nginx:1.27

SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]
WORKDIR /var/www/src

ENV TZ=UTC

COPY ./infra/docker/nginx/nginx.conf /etc/nginx/
COPY ./infra/docker/nginx/default.conf /etc/nginx/conf.d/

RUN <<EOF
  groupmod -g 1000 nginx
  usermod -u 1000 nginx
  chown -R nginx:nginx /var/cache/nginx/ \
        /var/run/ \
        /var/log/nginx/
EOF