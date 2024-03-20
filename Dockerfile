# Use a imagem oficial do PHP
FROM php:8.3-apache

# Instale extensões PHP necessárias para o Symfony e as dependências do ICU
RUN apt-get update && \
    apt-get install -y libicu-dev && \
    docker-php-ext-install pdo_mysql intl

RUN apt-get install -y \
        zip \
        unzip \
    && rm -rf /var/lib/apt/lists/*

# Habilitar o módulo Apache mod_rewrite para permitir URLs amigáveis
RUN a2enmod rewrite

# Definir o diretório de trabalho no contêiner
WORKDIR /var/www/html

RUN chmod -R 777 /var/

RUN sed -i -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Definir variável de ambiente para permitir o uso do Composer como superusuário
ENV COMPOSER_ALLOW_SUPERUSER=1

# Instalar o Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .

# Expor a porta 80 para acessar o aplicativo Symfony
EXPOSE 80

# Comando para iniciar o Apache
CMD ["apache2-foreground"]


