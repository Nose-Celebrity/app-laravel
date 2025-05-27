# ステージ1: ビルド環境 (依存関係のインストールと最適化)
FROM php:8.2-fpm-alpine AS builder

# 環境変数
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_NO_INTERACTION=1 \
    APP_ENV=production \
    COMPOSER_MEMORY_LIMIT=-1

# 必要なシステムライブラリ
# fileinfoに必要なlibmagicのために file-dev を追加
# oniguruma-dev は mbstring に必要
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
    libxml2-dev \
    libxslt-dev \
    git \
    file-dev

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# .dockerignore ファイルで不要なファイル (.git, .env, node_modules, storage/logs/* など) を除外しておくこと
COPY . .

# ★ビルド時専用の.envファイルを用意
#   この .env.build の中で CACHE_STORE=file, SESSION_DRIVER=file, QUEUE_CONNECTION=sync
#   DB_CONNECTION=sqlite, DB_DATABASE=:memory: など、ビルド時にエラーが出ない設定をする
COPY .env.build .env

# Composerで依存関係をインストール (本番用)
# --no-scripts を外して、Laravelの標準スクリプト(package:discoverなど)を実行させる
RUN composer install --prefer-dist --no-dev --optimize-autoloader

# PHP拡張機能のインストール
# コアに含まれていない、あるいは明示的なコンパイルが必要なものを中心に
# json, openssl, ctype, tokenizer は通常PHP8.2コアに含まれるかデフォルト有効

RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install -j$(nproc) intl

# fileinfo は file-dev を入れたので、これで通るはず
RUN docker-php-ext-install -j$(nproc) fileinfo

RUN docker-php-ext-install -j$(nproc) \
    pdo pdo_mysql \
    zip \
    opcache \
    exif \
    bcmath \
    mbstring \
    xml \
    xsl
    # ctype, json, openssl, tokenizer はPHP8.2コアに含まれるかデフォルト有効なのでリストから外してある
    # もし実行時に「ない」と怒られたら、その時に追加でインストールを試す

# Redis拡張 (もし使うなら)
RUN pecl install redis && docker-php-ext-enable redis

# Laravelの最適化 (本番用)
# .env.build でキャッシュ等がファイルベースになっていれば、DBエラーは出ないはず
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan event:cache && \
    php artisan optimize:clear

# ステージ2: 最終的な実行環境 (軽量なイメージ)
FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

# www-dataユーザーとグループはAlpineのphp:fpmイメージにデフォルトで存在する (uid 82, gid 82)

# builderステージからアプリケーションコード(vendor含む)と最適化済みファイルをコピー
COPY --from=builder /var/www/html .

# builderステージから有効化されたPHP拡張の設定ファイル(.ini)をコピー
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

# ★★★ ここが超重要！ ★★★
# builderステージでコンパイル・インストールされた拡張機能の .so ファイルをコピーする！
# PHPの拡張機能ディレクトリは php -i | grep extension_dir で確認できるけど、
# php:8.2-fpm-alpine やと、だいたい /usr/local/lib/php/extensions/no-debug-non-zts-20220829/ になるはず。
COPY --from=builder /usr/local/lib/php/extensions/no-debug-non-zts-20220829/ /usr/local/lib/php/extensions/no-debug-non-zts-20220829/
# ★★★★★★★★★★★★★★★★★★

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