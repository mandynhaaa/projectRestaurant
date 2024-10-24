# Use a imagem base do PHP 8.3 com Apache
FROM php:8.3-apache

# Copia a configuração do virtual host para o container
COPY docker/php.cnf/000-default.conf /etc/apache2/sites-available/000-default.conf

# Habilita o mod_rewrite
RUN a2enmod rewrite

# Instala os pacotes necessários
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    libzip-dev \
    wget \
    git \
    unzip && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Instala as extensões do PHP
RUN docker-php-ext-install zip pdo_mysql

# Copia o script de instalação do Composer
COPY docker/php.cnf/install-composer.sh /install-composer.sh

# Executa o script de instalação do Composer
RUN bash /install-composer.sh && rm /install-composer.sh

# Instale o Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Define o diretório de trabalho
WORKDIR /var/www

# Altera o proprietário do diretório de documentos do container
RUN chown -R www-data:www-data /var/www

# Inicia o Apache em primeiro plano
CMD ["apache2-foreground"]