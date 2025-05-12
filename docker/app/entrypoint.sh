#!/bin/sh

php-fpm &  # バックグラウンドで起動
npm run dev &  # Vite もバックグラウンドで起動

# 両方がフォアグラウンドで生き続けるように監視
wait -n
