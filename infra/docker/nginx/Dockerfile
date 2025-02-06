FROM nginx:1.27

SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]
WORKDIR /var/www/src

ENV TZ=UTC

COPY ./infra/docker/nginx/*.conf /etc/nginx/conf.d/