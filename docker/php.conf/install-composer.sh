#!/bin/bash

# Instala o Composer sem verificação de assinatura
# Garantimos que wget e ca-certificates estão instalados
apt-get update && apt-get install -y --no-install-recommends wget ca-certificates

# Baixa o instalador do Composer diretamente
wget -O composer-setup.php https://getcomposer.org/installer

# Instala o Composer
php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# Remove o arquivo de instalação temporário
rm composer-setup.php
