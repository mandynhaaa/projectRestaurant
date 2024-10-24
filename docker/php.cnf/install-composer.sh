#!/bin/bash

expected_signature="$(curl -sS https://composer.github.io/installer.sig)"
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
actual_signature="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"

if [ "$expected_signature" != "$actual_signature" ]; then
    >&2 echo 'ERROR: Invalid installer signature'
    rm composer-setup.php
    exit 1
fi

php composer-setup.php --install-dir=/usr/local/bin --filename=composer
rm composer-setup.php
