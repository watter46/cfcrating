FROM mysql:8.4.2
SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]

COPY ./infra/docker/mysql/my.cnf /etc/my.cnf

ENV LC_ALL ja_JP.UTF-8

USER mysql