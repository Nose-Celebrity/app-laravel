# ステージ1: ビルド環境 (依存関係のインストールと最適化)
FROM php:8.2-fpm-alpine AS builder

# 環境変数
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_NO_INTERACTION=1 \
    APP_ENV=production \
    COMPOSER_MEMORY_LIMIT=-1

# 必要なシステムライブラリ
# Laravelでよく使う拡張機能のために、これくらいは入れておくのが無難
RUN apk add --no-cache \
    build-base \
    autoconf \
    linux-headers \
    $PHPIZE_DEPS \
    libzip-dev \
    libpng-dev \
    jpeg-dev \
    freetype-dev \
    icu-dev \
    oniguruma-dev \ 
     # mbstring用
    libxml2-dev \
    libxslt-dev \
    git \
    file-dev 
    # fileinfo用 (libmagic)

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# アプリケーションのコードを先にコピー
COPY . .

# Composerで依存関係をインストール (本番用)
# --no-scriptsを外して、Laravelの標準スクリプトを実行させる
RUN composer install --prefer-dist --no-dev --optimize-autoloader

# PHP拡張機能のインストール
# コアに含まれていない、あるいは明示的なコンパイルが必要なものを中心に
# json, openssl, ctype, tokenizer, fileinfo の多くはPHP8.0以降コア機能かデフォルトで有効

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) \
    gd \
    intl \
    pdo pdo_mysql \
    zip \
    opcache \
    exif \
    bcmath \
    mbstring \
    xml \
    xsl
    # ctype, fileinfo, json, openssl, tokenizer は通常PHP8.2コアに含まれるかデフォルト有効なのでリストから外してみる
    # もし実行時に「ない」と怒られたら、追加でインストールを試す

# Redis拡張 (もし使うなら)
RUN pecl install redis && docker-php-ext-enable redis

# Laravelの最適化 (本番用)
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan event:cache && \
    php artisan optimize:clear

# ステージ2: 最終的な実行環境 (軽量なイメージ)
FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

# builderステージからアプリケーションコード(vendor含む)と最適化済みファイルをコピー
COPY --from=builder /var/www/html .

# builderステージから有効化されたPHP拡張の設定ファイルをコピー
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

# (オプション) カスタムPHP設定 (本番用)
# COPY php-prod.ini /usr/local/etc/php/conf.d/zz-custom-php-prod.ini

# ディレクトリの所有権とパーミッション設定
RUN mkdir -p /var/www/html/storage/framework/{sessions,views,cache} \
             /var/www/html/storage/logs \
             /var/www/html/bootstrap/cache && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache

# PHP-FPMのポート
EXPOSE 9000

# 実行ユーザー
USER www-data

# CMD ["php-fpm"]