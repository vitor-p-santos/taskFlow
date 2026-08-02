FROM node:22-alpine AS frontend

WORKDIR /app

COPY project/package*.json ./

RUN npm install

COPY project .

RUN npm run build


FROM php:8.3-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo pdo_mysql zip

COPY project .

COPY --from=frontend /app/public/build ./public/build

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install