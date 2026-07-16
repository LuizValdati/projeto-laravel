# Imagem base: PHP 8.4 com FPM (FastCGI Process Manager).
# O FPM é o processo que o nginx aciona para executar o PHP.
# (8.4 porque as dependências travadas no composer.lock exigem PHP >= 8.4.1.)
FROM php:8.4-fpm

# Dependências de sistema necessárias para compilar as extensões do PHP
# e para o Composer funcionar (git, unzip, etc.).
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# Extensões do PHP que o Laravel + MySQL precisam.
# pdo_mysql = driver para o banco; as demais são comuns em apps Laravel.
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Remapeia o usuário www-data (com quem o php-fpm roda) para o mesmo uid/gid
# do usuário do host. Como o código é montado por volume, isso garante que o
# php-fpm consiga escrever em storage/ e bootstrap/cache sem usar chmod 777.
ARG UID=1000
ARG GID=1000
RUN groupmod -g ${GID} www-data && usermod -u ${UID} -g ${GID} www-data

# Instala o Composer copiando o binário da imagem oficial do Composer.
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Diretório onde o código da aplicação vai viver dentro do container.
WORKDIR /var/www

# O php-fpm escuta na porta 9000 (é aqui que o nginx vai bater).
EXPOSE 9000
CMD ["php-fpm"]
