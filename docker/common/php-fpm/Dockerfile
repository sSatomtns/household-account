FROM php:8.5-fpm AS base

# Laravel + MySQLで必要になるライブラリとPHP拡張をインストール
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    unzip \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    intl \
    zip \
    bcmath \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www


# -------------------------
# Production
# -------------------------
FROM base AS production

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY . /var/www

RUN chown -R www-data:www-data /var/www

USER www-data

EXPOSE 9000

CMD ["php-fpm"]


# -------------------------
# Development
# -------------------------
FROM base AS development

ARG UID=1000
ARG GID=1000

USER root

# WSL側のユーザーとUID/GIDを合わせる
RUN if getent group ${GID} > /dev/null; then \
        GROUP_NAME=$(getent group ${GID} | cut -d: -f1); \
    else \
        groupadd -g ${GID} www && \
        GROUP_NAME=www; \
    fi && \
    useradd -m -u ${UID} -g ${GID} -s /bin/bash www && \
    sed -i "s/^user = .*/user = www/" /usr/local/etc/php-fpm.d/www.conf && \
    sed -i "s/^group = .*/group = ${GROUP_NAME}/" /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www

USER www

EXPOSE 9000

CMD ["php-fpm"]
