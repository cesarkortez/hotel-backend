FROM php:8.2-cli

# Instala dependencias del sistema y extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
  && docker-php-ext-install pdo pdo_mysql pdo_pgsql

# Establece el directorio de trabajo
WORKDIR /var/www

# Copia todo el proyecto (incluyendo artisan)
COPY . /var/www

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala las dependencias de PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Crea el archivo .env a partir de .env.example (necesario para Artisan)
RUN cp .env.example .env

# Genera la clave de la aplicación
RUN php artisan key:generate

# IMPORTANTE: Limpia la caché de configuración
RUN php artisan config:clear

# Expone el puerto 8000
EXPOSE 8000

# Comando para iniciar el servidor de Laravel
CMD ["/bin/sh", "-c", "php artisan config:clear && php artisan serve --host 0.0.0.0 --port 8000"]
