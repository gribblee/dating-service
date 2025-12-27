FROM php:8.4-fpm

# system deps
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libcurl4-openssl-dev \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    libxml2-dev \
    libonig-dev \
    procps \
    iputils-ping \
    netcat-openbsd \
    openssl -y \
    libssl-dev -y\
    wget -y \
    git -y \
    procps -y \
    htop -y \
    libbrotli-dev \
    pkg-config \
    && docker-php-ext-install \
        pgsql \
        intl \
        zip \
        opcache \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && pecl install igbinary \
    && docker-php-ext-enable igbinary \
    && pecl install ds \
    && docker-php-ext-enable ds \
    && pecl install simdjson \
    && docker-php-ext-enable simdjson

#RUN cd /tmp && git clone https://github.com/swoole/swoole-src.git && \
#    cd swoole-src && \
#    phpize  && \
#    ./configure  --enable-openssl --enable-json --enable-coroutine --enable-async-redis --enable-swoole-curl --enable-swoole-pgsql --enable-task && \
#    make && make install

#RUN touch /usr/local/etc/php/conf.d/swoole.ini && \
#    echo 'extension=swoole.so' > /usr/local/etc/php/conf.d/swoole.ini

RUN apt-get clean \
      && rm -rf /var/lib/apt/lists/*

# php + xdebug config
COPY docker/php-dev/php.ini /usr/local/etc/php/php.ini
COPY docker/php-dev/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# ⬇️ dev-инструменты
RUN composer global require \
    vimeo/psalm \
    friendsofphp/php-cs-fixer


#RUN composer install --no-scripts --optimize-autoloader
#RUN composer dump-autoload --optimize

ENV PATH="/root/.composer/vendor/bin:${PATH}"
