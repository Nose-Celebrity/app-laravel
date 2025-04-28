FROM php:fpm-alpine
ARG USERNAME=vscode
ARG USER_UID=1000
ARG USER_GID=$USER_UID

# composerの移植
COPY --from=composer/composer /usr/bin/composer /usr/bin/composer

# 必須と思われるPHP拡張の導入
RUN apk add --no-cache \
    git \
    zip \
    unzip
# Pythonの導入
RUN apk add --no-cache \
    python3 \
    py3-pip
RUN apk add --no-cache \
    github-cli make sudo
# RUN pecl install xdebug \
#     && docker-php-ext-enable xdebug
RUN docker-php-ext-install mysqli pdo_mysql
# やはりbashは最低限必要ですね
RUN apk add --no-cache bash bash-completion
# 作業用ユーザーの作成、シェルは/bin/sh
RUN addgroup -g $USER_GID $USERNAME \
    && adduser -u $USER_UID -G $USERNAME -s /bin/bash -D $USERNAME
# $USERNAMEにはsudo権限を付与
RUN echo "$USERNAME ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers.d/$USERNAME
# composerのラッパーをインストール
COPY composer /usr/local/bin/composer
RUN chmod 755 /usr/local/bin/composer
# シェル補完用の設定を追加
RUN cd /usr/share/bash-completion/completions; \
    composer completion bash > composer
USER ${USERNAME}
ENV PATH="/home/${USERNAME}/.composer/vendor/bin:/home/${USERNAME}/.local/bin:${PATH}"
WORKDIR /app

