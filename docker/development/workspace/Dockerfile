FROM php:8.5-cli

ARG UID=1000
ARG GID=1000
ARG NODE_VERSION=22

RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    unzip \
    git \
    sudo \
    libonig-dev \
    libssl-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    intl \
    zip \
    bcmath \
    && curl -sS https://getcomposer.org/installer \
        | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN if getent group ${GID}; then \
        useradd -m -u ${UID} -g ${GID} -s /bin/bash www; \
    else \
        groupadd -g ${GID} www && \
        useradd -m -u ${UID} -g www -s /bin/bash www; \
    fi && \
    usermod -aG sudo www && \
    echo 'www ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

USER www

RUN export NVM_DIR="$HOME/.nvm" && \
    curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.0/install.sh | bash && \
    . "$NVM_DIR/nvm.sh" && \
    nvm install ${NODE_VERSION} && \
    nvm alias default ${NODE_VERSION}

RUN echo 'export NVM_DIR="$HOME/.nvm"' >> /home/www/.bashrc && \
    echo '[ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh"' >> /home/www/.bashrc

WORKDIR /var/www

ENTRYPOINT []

CMD ["bash"]
