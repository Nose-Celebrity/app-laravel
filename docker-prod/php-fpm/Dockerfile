# ステージ1: ビルド環境 (依存関係のインストールと最適化)
FROM php:8.2-fpm-alpine AS builder

# 環境変数
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_NO_INTERACTION=1 \
    APP_ENV=production \
    COMPOSER_MEMORY_LIMIT=-1

# PHP拡張機能のビルドに必要な依存関係を一時的にインストールするための仮想パッケージ名
ARG BUILD_DEPS_ALIAS=.build-deps

# PHP拡張機能のビルドに必要なライブラリと、実行時にも必要なライブラリを定義
# Alpineのパッケージ名はDebian系と違うことがあるから注意やで
# ここでは、Laravelでよく使う拡張機能の依存を想定してる
RUN apk add --no-cache \
    # 実行時にも必要なライブラリ (ここにリストアップ)
    icu-libs \
    libzip \
    libpng \
    libjpeg-turbo \
    freetype \
    oniguruma \ 
    # mbstring用
    libxml2 \
    libxslt \
    # fileinfo用のlibmagic (fileパッケージに含まれることが多い)
    file \
    # Redis拡張を使うなら、php-redisが依存するライブラリ (通常は特にないか、phpイメージに含まれる)
    # その他、アプリが実行時に必要とするシステムライブラリがあればここに追加
    # ビルド時にのみ必要なライブラリ (これらは後でまとめて削除される)
    --virtual ${BUILD_DEPS_ALIAS} \
    build-base \
    autoconf \
    linux-headers \
    $PHPIZE_DEPS \
    icu-dev \
    libzip-dev \
    libpng-dev \
    jpeg-dev \
    freetype-dev \
    oniguruma-dev \
    libxml2-dev \
    libxslt-dev \
    git
    # composerやpeclがgitリポジトリを参照する場合
# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# .dockerignore ファイルで不要なファイルを除外しておくこと
COPY . .

# ビルド時専用の.envファイル (キャッシュドライバをfileにするなど)
COPY .env.build .env

# Composerで依存関係をインストール (本番用)
RUN composer install --prefer-dist --no-dev --optimize-autoloader

# PHP拡張機能のインストールと設定
# docker-php-ext-configure は、ビルド時に必要なライブラリがインストールされた後に行う
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    # opcacheはPHPコアバンドルやけど、有効化のためにdocker-php-ext-enableを使うか、
    # php.iniで設定する。ここではdocker-php-ext-enable opcache を使う例。
    docker-php-ext-enable opcache && \
    docker-php-ext-install -j$(nproc) \
        gd \
        intl \
        pdo pdo_mysql \
        zip \
        exif \
        bcmath \
        mbstring \
        xml \
        xsl \
        fileinfo 
        # PHP8.1以降はデフォルトで有効なことが多いが、Alpineではlibmagicが必要

# Redis拡張 (もし使うなら)
# RUN pecl install redis && docker-php-ext-enable redis
# pecl install がビルドツール (make, gccなど) を必要とするので、
# apk del ${BUILD_DEPS_ALIAS} の前に実行する

# Laravelの最適化 (本番用)
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan event:cache && \
    php artisan optimize:clear

# 不要になったビルド時専用の依存関係を削除
RUN apk del ${BUILD_DEPS_ALIAS}

# ステージ2: 最終的な実行環境 (軽量なイメージ)
FROM php:8.2-fpm-alpine

# PHP拡張機能の実行に必要なライブラリだけをインストール
# builderステージの最初のapk addで、--virtualなしでリストアップしたやつと同じものを入れる
RUN apk add --no-cache \
    icu-libs \
    libzip \
    libpng \
    libjpeg-turbo \
    freetype \
    oniguruma \
    libxml2 \
    libxslt \
    file
    # redis拡張を使うなら、php82-pecl-redis みたいな実行時パッケージがあるか、
    # あるいはbuilderステージから.soファイルをコピーする必要がある。
    # ここではpeclで入れたredis.soをコピーする例を示す。

WORKDIR /var/www/html

# builderステージからアプリケーションコード(vendor含む)と最適化済みファイルをコピー
COPY --from=builder /var/www/html .

# builderステージから有効化されたPHP拡張の設定ファイル(.ini)をコピー
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

# ★builderステージでコンパイルされた拡張機能の .so ファイルをコピー (パスを直接指定)
COPY --from=builder /usr/local/lib/php/extensions/no-debug-non-zts-20220829/ /usr/local/lib/php/extensions/no-debug-non-zts-20220829/


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