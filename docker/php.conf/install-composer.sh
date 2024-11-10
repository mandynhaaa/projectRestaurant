# #!/bin/bash

# expected_signature="$(curl -sS https://composer.github.io/installer.sig)"
# php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
# actual_signature="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"

# if [ "$expected_signature" != "$actual_signature" ]; then
#     >&2 echo 'ERROR: Invalid installer signature'
#     rm composer-setup.php
#     exit 1
# fi

# php composer-setup.php --install-dir=/usr/local/bin --filename=composer
# rm composer-setup.php


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
