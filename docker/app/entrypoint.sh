#!/bin/sh

php-fpm &
npm run dev &

wait

