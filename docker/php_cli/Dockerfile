FROM php:8.3-cli as base

ENV T_MODE=base

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff

#region Amqp
# RUN apt-get update \
#     && apt-get install -y librabbitmq-dev libssh-dev \
#     && docker-php-ext-install opcache bcmath sockets \
#     && pecl install amqp \
#     && docker-php-ext-enable amqp
RUN apt-get update \
    && apt-get install -y \
        librabbitmq-dev \
        libssh-dev \
    && docker-php-ext-install \
        bcmath \
        sockets \
    && pecl install amqp \
    && docker-php-ext-enable amqp
#endregion

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && apt-get install -y libjpeg-dev \
    && apt-get install -y zip \
    && apt-get install -y unzip \
    && apt-get install -y git \
    && apt-get install -y curl \
    && apt-get install -y nano \
    && postgresql-dev \
    # Extensions
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install pgsql \
    # Enable extensions
    && docker-php-ext-enable pdo_pgsql \
    && docker-php-ext-enable pgsql \
    # Image extensions
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install gd \
    # Install
    && apt-get -y --no-install-recommends install imagemagick php8.3-imagick php8.3-pgsql pdo_pgsql php8.3-mysql pdo nano php8.3-gd php8.3-redis php8.3-bcmath php8.3-zmq \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Create image
# RUN apt-get install docker-php-ext-configure gd --with-jpeg \
    # && docker-php-ext-install gd

#region Postgres Extensions
# RUN set -ex \
#   && apk --no-cache add \
#     postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
#endregion

# Install MySQLi
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Install PDO
RUN docker-php-ext-install pdo_mysql

# Composer installing
#RUN curl -sS https://getcomposer.org/installer | php \
#    && mv composer.phar /usr/local/bin/ \
#    && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

WORKDIR /var/project

FROM base as develop

ENV T_MODE=develop

# Composer installing
#RUN curl -sS https://getcomposer.org/installer | php \
#    && mv composer.phar /usr/local/bin/ \
#    && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

FROM base as production

ENV T_MODE=production

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
