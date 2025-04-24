# composerから取り込むものがあるので仕込み
FROM composer/composer:2-bin AS composer

# ---  ベースイメージの作成
FROM php:fpm-alpine
ARG USERNAME=vscode
ARG USER_UID=1000
ARG USER_GID=$USER_UID

# composerの移植
COPY --from=composer /composer /usr/bin/composer

# 必須と思われるPHP拡張の導入
RUN apk add --no-cache \
    git~=2 \
    zip~=3 \
    unzip=~6 && \
    rm -fr /var/cache/apk
# Pythonの導入
RUN apk add --no-cache \
    python3~=3.12 \
    py3-pip~=24 && \
    rm -fr /var/cache/apk
RUN apk add --no-cache \
    github-cli~=2 \
    make~=4 \
    sudo~=1 && \
    rm -fr /var/cache/apk
# RUN pecl install xdebug \
#     && docker-php-ext-enable xdebug
RUN docker-php-ext-install mysqli pdo_mysql
# やはりbashは最低限必要ですね
RUN apk add --no-cache \
    bash~=5.2 \
    bash-completion~=2 && \
    rm -fr /var/cache/apk
# 作業用ユーザーの作成、シェルは/bin/sh
RUN addgroup -g $USER_GID $USERNAME \
    && adduser -u $USER_UID -G $USERNAME -s /bin/bash -D $USERNAME
# $USERNAMEにはsudo権限を付与
RUN echo "$USERNAME ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers.d/$USERNAME
# composerのラッパーをインストール
COPY composer /usr/local/bin/composer
RUN chmod 755 /usr/local/bin/composer

# シェル補完用の設定を追加
WORKDIR /usr/share/bash-completion/completions
RUN /usr/bin/composer completion bash > composer

# hadolint ignore=DL3059
WORKDIR /app
RUN chown -R "${USERNAME}:${USERNAME}" /app

USER ${USERNAME}
ENV PATH="/home/${USERNAME}/.composer/vendor/bin:/home/${USERNAME}/.local/bin:${PATH}"

