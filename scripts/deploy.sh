#!/bin/bash

APP_DIR="/home/stellijanos/domains/restaurant-app.stellijanos.com/public_html"

cd $APP_DIR || exit

php artisan down

git pull

composer install --no-dev

npm install

npm run prod

php artisan migrate --force

php artisan config:cache

php artisan up
