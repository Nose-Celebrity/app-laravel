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
    unzip \
    nodejs \
    npm
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

# 作業ディレクトリの設定
WORKDIR /app

# package.json と package-lock.json を最初にコピーして npm install
COPY package*.json ./
RUN npm install

# node_modules の権限を変更 (node_modules が存在する場合のみ)
RUN if [ -d "/app/node_modules" ]; then chown -R $USER_UID:$USER_GID /app/node_modules; fi

# 作業ディレクトリをコピー
COPY . .

# エントリーポイントスクリプトの設定
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# シェル補完用の設定を追加
RUN cd /usr/share/bash-completion/completions; \
    composer completion bash > composer

# ユーザーを指定
USER ${USERNAME}

# PATH環境変数の設定
ENV PATH="/home/${USERNAME}/.composer/vendor/bin:/home/${USERNAME}/.local/bin:${PATH}"

# 最後にエントリーポイントスクリプトを実行
CMD ["/usr/local/bin/entrypoint.sh"]
