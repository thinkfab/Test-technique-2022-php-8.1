FROM thecodingmachine/php:8.1.6-v4-fpm

ENV PHP_EXTENSION_APCU=1
ENV PHP_EXTENSION_INTL=1
ENV PHP_EXTENSION_GD=1
ENV PHP_EXTENSION_PDO_MYSQL=1
ENV PHP_EXTENSION_XDEBUG=0
ENV PHP_INI_MEMORY_LIMIT=512M
ENV PHP_INI_UPLOAD_MAX_FILESIZE=30M
ENV PHP_INI_POST_MAX_SIZE=30M
ENV TEMPLATE_PHP_INI: production


ENV TZ="Europe/Paris"

RUN sudo apt update

## WKHTMLTOPDF
RUN sudo apt install -y wget libxrender1 libxtst6 libxi6 \
    && wget https://github.com/wkhtmltopdf/wkhtmltopdf/releases/download/0.12.4/wkhtmltox-0.12.4_linux-generic-amd64.tar.xz \
    && tar vxf wkhtmltox-0.12.4_linux-generic-amd64.tar.xz \
    && sudo cp wkhtmltox/bin/wkhtmltopdf /usr/bin/ \
    && rm -R wkhtmltox-0.12.4_linux-generic-amd64.tar.xz wkhtmltox/

RUN sudo apt install -y mysql-client

RUN sudo apt-get clean \
    && sudo rm -rf /var/lib/apt/lists/*
