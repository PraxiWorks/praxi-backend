# Use a imagem oficial do PHP com FPM
FROM php:8.3-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_pgsql zip

# Instalar Xdebug para cobertura de código
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Configurar Xdebug
RUN echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=no" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Instalar Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Definir o diretório de trabalho
WORKDIR /var/www/html

# Copiar o código do projeto para o contêiner
COPY . .

# Instalar dependências do Laravel (inclusive as de desenvolvimento)
RUN composer install --optimize-autoloader

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

RUN chown -R www-data:www-data /var/www/html/public/coverage
RUN chmod -R 775 /var/www/html/public/coverage

# Expor a porta do PHP-FPM
EXPOSE 9000

# Comando para iniciar o PHP-FPM
CMD ["php-fpm"]
