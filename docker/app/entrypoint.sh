#!/bin/sh

# Laravel/PHP-FPM 起動
php-fpm &

# Vite の開発サーバー起動
npm run dev
