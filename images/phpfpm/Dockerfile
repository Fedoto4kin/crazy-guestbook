# PHP Docker image for Yii 2.0 Framework runtime
# ==============================================

FROM php:7.4-fpm

#TODO: ADD CURRENT USER
#ARG USER_ID
#ARG GROUP_ID

# Install system packages for PHP extensions recommended for Yii 2.0 Framework
ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get update && \
    apt-get -y install \
        gnupg2 && \
    apt-key update && \
    apt-get update && \
    apt-get -y install \
            g++ \
            git \
            curl \
            imagemagick \
            libcurl3-dev \
            libicu-dev \
            libfreetype6-dev \
            libjpeg-dev \
            libjpeg62-turbo-dev \
            libonig-dev \
            libmagickwand-dev \
            libpq-dev \
            libpng-dev \
            libxml2-dev \
            libzip-dev \
            zlib1g-dev \
            default-mysql-client \
            openssh-client \
            nano \
            unzip \
            libcurl4-openssl-dev \
            libssl-dev \
        --no-install-recommends && \
        apt-get clean && \
        rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install PHP extensions required for Yii 2.0 Framework

RUN docker-php-ext-configure gd \
    --with-freetype-dir=/usr/include/ \
    --with-png-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/; \
    docker-php-ext-configure bcmath && \
    docker-php-ext-install \
        soap \
        zip \
        curl \
        bcmath \
        exif \
        gd \
        iconv \
        intl \
        mbstring \
        opcache \
        pdo_mysql \
        pdo_pgsql

# Install PECL extensions
# see http://stackoverflow.com/a/8154466/291573) for usage of `printf`
ARG PECL_XDEBUG_INSTALL_SUFFIX
ARG PECL_MONGODB_INSTALL_SUFFIX
RUN printf "\n" | pecl install \
        imagick \
        xdebug${PECL_XDEBUG_INSTALL_SUFFIX} \
        mongodb${PECL_MONGODB_INSTALL_SUFFIX} && \
        docker-php-ext-enable \
        imagick \
        mongodb


# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer clear-cache


# Install composer plugins
RUN composer global require --optimize-autoloader \
    && composer global dumpautoload --optimize  \
    && composer clear-cache

#USER "${USER_ID}:${GROUP_ID}"

# Application environment
WORKDIR /var/www
