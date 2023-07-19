FROM alpine:3.16 as php-base

RUN set -x \
    && adduser -u 82 -D -S -G www-data www-data \
    && apk add --update --no-cache \
        libc6-compat \
        php81 \
        php81-ctype \
        php81-iconv \
        php81-intl \
        php81-mbstring \
        php81-opcache \
        php81-posix \
        php81-sockets \
        php81-sodium \
        php81-tokenizer \
        php81-xml \
        php81-xmlreader \
        php81-xmlwriter \
        php81-pdo \
        php81-pdo_pgsql \
        php81-pdo_mysql \
        php81-pgsql \
        php81-session \
        libstdc++ \
        libxml2-dev \
        php81-curl \
        php81-openssl \
        php81-phar \
        php81-zip \
    && ln -sf /lib/libc.musl-x86_64.so.1 /lib/ld-linux-x86-64.so.2 \
    && ln -sf /usr/bin/php81 /usr/bin/php \
    && wget -q -O- https://github.com/just-containers/s6-overlay/releases/download/v2.2.0.3/s6-overlay-amd64.tar.gz | tar -xz -C / \
;
#---

FROM php-base as php-composer

WORKDIR /app
ARG COMPOSER_AUTH={}
ENV COMPOSER_AUTH=${COMPOSER_AUTH}

RUN set -x \
    && apk add --no-cache \
        git \
        php81 \
        php81-openssl \
        php81-phar \
        php81-zip \
        php81-pecl-xdebug \
    && wget -q -O /usr/local/bin/composer https://getcomposer.org/download/2.4.1/composer.phar \
    && chmod a+x /usr/local/bin/composer \
    && /usr/local/bin/composer --version \
;

ARG COMPOSER_MEMORY_LIMIT=128M
ENV COMPOSER_MEMORY_LIMIT=${COMPOSER_MEMORY_LIMIT}

COPY ./app/composer.json ./app/composer.lock /app/
RUN set -x \
    && cd /app/ \
    && php -d allow_url_fopen=1 -d memory_limit=$COMPOSER_MEMORY_LIMIT /usr/local/bin/composer install --no-dev --no-scripts;

RUN wget -q -O /usr/local/bin/rr https://cdn.divan.ru/app/v1/bin/rr
RUN chmod a+x /usr/local/bin/rr \
    && /usr/local/bin/rr --version \
;

COPY ./app /app/
RUN set -x \
    && cd /app/ \
    && php -d allow_url_fopen=1 -d memory_limit=$COMPOSER_MEMORY_LIMIT /usr/local/bin/composer dump-autoload --no-dev --classmap-authoritative \
    && php -d allow_url_fopen=1 -d memory_limit=$COMPOSER_MEMORY_LIMIT /usr/local/bin/composer check-platform-reqs \
;

#---

FROM php-base

WORKDIR /app


COPY --from=php-composer /app /app
COPY --from=php-composer /usr/lib/php81/modules/xdebug.so /usr/lib/php81/modules/xdebug.so
COPY --from=php-composer /usr/local/bin/rr /usr/local/bin/rr
COPY --from=php-composer /usr/local/bin/composer /usr/local/bin/composer

ARG USER_ID=1000
ARG GROUP_ID=1000

RUN chown -R ${USER_ID}:${GROUP_ID} /app

EXPOSE 8080

CMD ["/usr/local/bin/rr", "serve"]
