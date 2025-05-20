#!/bin/sh
set -e

echo "🔧 Starting PHP-FPM..."
exec php-fpm &

# give PHP-FPM a moment to initialize (optional)
sleep 1

echo "🔧 Starting Vite (npm run dev)..."
# `exec` を最後に使うことで、このシェルが Vite プロセスに置き換わり、
# コンテナにも直接シグナルが届くようになります。
exec npm run dev
