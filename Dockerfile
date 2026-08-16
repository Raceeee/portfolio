# ---- Stage 1: build frontend assets with Node/Vite ----
FROM node:20-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json* ./
RUN npm install

COPY resources ./resources
COPY vite.config.js ./
COPY public ./public

RUN npm run build

# ---- Stage 2: PHP application (nginx + php-fpm bundled image) ----
FROM richarvey/nginx-php-fpm:3.1.6

# Copy the whole Laravel app in
COPY . /var/www/html

# Overwrite public/build with the compiled assets from stage 1
COPY --from=assets /app/public/build /var/www/html/public/build

# Deploy script (runs automatically on container start, see base image docs)
COPY docker/00-laravel-deploy.sh /var/www/html/scripts/00-laravel-deploy.sh
RUN chmod +x /var/www/html/scripts/00-laravel-deploy.sh

# Base image configuration
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV SKIP_COMPOSER=1
ENV COMPOSER_ALLOW_SUPERUSER=1

CMD ["/start.sh"]
