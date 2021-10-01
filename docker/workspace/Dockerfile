FROM php:8.0-fpm-alpine

COPY ./docker/workspace/run.sh /tmp

WORKDIR /var/www/html

ENTRYPOINT ["/tmp/run.sh"]