FROM php:8.2-alpine

RUN apk add \
    linux-headers \
    autoconf \
    bash \
    g++ \
    make

# install xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# change id of www-data user and group to match the host user and group
ARG USER_ID
ARG GROUP_ID
RUN apk add shadow && \
    usermod -u ${USER_ID} www-data \
    && groupmod -g ${GROUP_ID} www-data
