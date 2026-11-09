FROM php:8.4-cli

RUN apt-get update && apt-get install -y git unzip curl libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql zip gd mbstring bcmath exif pcntl \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app
COPY job-shared ./job-shared
COPY job-app ./job-app
COPY job-back-office/database/migrations ./job-back-office/database/migrations

WORKDIR /app/job-app
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm ci && npm run build && rm -rf node_modules

CMD php artisan migrate --force --path=/app/job-back-office/database/migrations --realpath && (php artisan storage:link || true) && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}