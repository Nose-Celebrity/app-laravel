FROM php:fpm-alpine

ARG USERNAME=vscode
ARG USER_UID=1000
ARG USER_GID=$USER_UID

# composerの移植
COPY --from=composer/composer /usr/bin/composer /usr/bin/composer

# 必須と思われるPHP拡張と開発系ツールの導入
RUN apk add --no-cache \
    git \
    zip \
    unzip \
    python3 \
    py3-pip \
    github-cli \
    make \
    sudo \
    bash \
    bash-completion \
    autoconf \
    gcc \
    g++ \
    make \
    linux-headers \
    $PHPIZE_DEPS

# PHP拡張
RUN docker-php-ext-install mysqli pdo_mysql

# redis 拡張（root権限で）
RUN pecl install redis && docker-php-ext-enable redis

# 作業用ユーザーの作成、シェルは/bin/bash
RUN addgroup -g $USER_GID $USERNAME \
    && adduser -u $USER_UID -G $USERNAME -s /bin/bash -D $USERNAME \
    && echo "$USERNAME ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers.d/$USERNAME

# composerのラッパーをインストール
COPY composer /usr/local/bin/composer
RUN chmod 755 /usr/local/bin/composer

# 作業ディレクトリの設定
WORKDIR /app


# 作業ディレクトリをコピー
COPY . .

# シェル補完用の設定を追加
RUN cd /usr/share/bash-completion/completions; \
    composer completion bash > composer

# ユーザーを指定
USER ${USERNAME}

# PATH環境変数の設定
ENV PATH="/home/${USERNAME}/.composer/vendor/bin:/home/${USERNAME}/.local/bin:${PATH}"
