FROM php:8.1-apache

# Apache mod_rewrite'ı etkinleştir
RUN a2enmod rewrite

# Gerekli PHP uzantılarını yükle
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql zip

# Composer'ı yükle
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Çalışma dizinini ayarla
WORKDIR /var/www/html

# Composer dosyalarını kopyala ve bağımlılıkları yükle
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Uygulama dosyalarını kopyala
COPY . .

# Apache konfigürasyonu
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Dosya izinlerini ayarla
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && mkdir -p uploads public/downloads \
    && chown -R www-data:www-data uploads public/downloads \
    && chmod -R 777 uploads public/downloads

# Port'u belirt
EXPOSE 80

# Apache'yi başlat
CMD ["apache2-foreground"]