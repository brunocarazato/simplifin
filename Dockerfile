# Usa imagem oficial do PHP com Alpine
FROM php:8.2-fpm-alpine

# Define variáveis de ambiente básicas para evitar interações
ENV COMPOSER_ALLOW_SUPERUSER=1

# Instala dependências de sistema e extensões PHP necessárias
RUN apk update && apk add --no-cache \
    bash \
    curl \
    git \
    unzip \
    libpng \
    libpng-dev \
    libzip-dev \
    oniguruma-dev \
    autoconf \
    g++ \
    make \
    icu-dev \
    mysql-client \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        intl \
        zip \
    && rm -rf /var/cache/apk/*

# Instala o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Cria diretório de trabalho
WORKDIR /var/www

# Copia os arquivos da aplicação para o container
COPY . /var/www

# Executa o Composer install (pode ser feito na build ou em runtime)
RUN composer install --no-interaction --prefer-dist --no-dev

# Permissões para o www-data
RUN chown -R www-data:www-data /var/www

# Expõe a porta padrão do PHP-FPM (não é obrigatória)
EXPOSE 9000

# Comando padrão
CMD ["php-fpm"]
