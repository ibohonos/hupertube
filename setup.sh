#!/bin/sh

npm i;
php artisan storage:link;
cp .env.example .env
php artisan key:generate;
npm run prod;
