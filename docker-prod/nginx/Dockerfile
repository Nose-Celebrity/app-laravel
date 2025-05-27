# ベースイメージ
FROM nginx:1.27-alpine-slim 
# alpine-slim の方がより軽量なことが多い (nginx:alpineでもOK)
# Nginxの設定ファイルをコピー
# COPY laravel.conf /etc/nginx/conf.d/default.conf # これはあんたの設定ファイル名に合わせる
# もし、ファイル名が `nginx-prod.conf` で、Dockerfileと同じディレクトリにあるなら下のようにする
COPY nginx-prod.conf /etc/nginx/conf.d/default.conf

# (オプション) Laravelの静的アセット (publicディレクトリの中身) をNginxが直接配信する場合
# もしPHP-FPMコンテナに全てのリクエストを流すなら、このセクションは不要なこともある。
# その場合は、Nginxの設定ファイル (nginx-prod.conf) の中で、
# 静的ファイルへのリクエストもPHP-FPMに流すか、
# あるいはPHP-FPMコンテナからNginxコンテナにpublicディレクトリをマウントする
# (KubernetesのPod定義でemptyDirボリュームとか使う) 必要がある。
#
# ここでは、マルチステージビルドでPHP-FPMイメージのbuilderステージから
# ビルド済みアセットを含むpublicディレクトリをコピーする例を示すで。
# このためには、PHP-FPMのDockerfileのbuilderステージで、
# npm run build (Vite/Mixとか) を実行して、public/build ディレクトリとかに
# アセットが生成されてる必要がある。
#
# ARG PHP_FPM_IMAGE_NAME=my-laravel-app-fpm # CIワークフローからビルド引数で渡す想定
# COPY --from=${PHP_FPM_IMAGE_NAME}:latest /var/www/html/public /var/www/html/public
# ↑ これはGitHub ActionsのワークフローでPHP-FPMイメージを先にビルドしてプッシュしてる前提。
#   あるいは、Dockerfileを一つにまとめてマルチステージビルドするなら、
#   COPY --from=php-builder-stage /var/www/html/public /usr/share/nginx/html/public
#   みたいに、PHP-FPMのDockerfileのbuilderステージ名を指定する。
#   ここでは、Nginxが直接静的ファイルを配信する設定を`nginx-prod.conf`で行う前提で、
#   静的ファイルはPHP-FPMコンテナからマウントするか、
#   あるいはNginxコンテナにはLaravelのコードは含めず、全てPHP-FPMにプロキシする構成を推奨する。
#   シンプルにするなら、Nginxは純粋なリバースプロキシとしてPHP-FPMに流すのがええ。
#   その場合、下のCOPYは不要。

# Nginxが実行されるユーザーとグループ (alpineのnginxはデフォルトでnginxユーザー)
# 特に指定せんでも、ベースイメージのユーザーで動くはずや。

# Nginxのログを標準出力/標準エラー出力に向ける (コンテナのログとして見れるように)
RUN ln -sf /dev/stdout /var/log/nginx/access.log && \
    ln -sf /dev/stderr /var/log/nginx/error.log

EXPOSE 80

# CMD はベースイメージ (`nginx:alpine`) に含まれている ["nginx", "-g", "daemon off;"] を使うので通常不要
# CMD ["nginx", "-g", "daemon off;"]