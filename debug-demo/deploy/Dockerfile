From ctftraining/base_image_nginx_mysql_php_73

MAINTAINER zmlad "2021201675@ruc.edu.cn"

COPY ./files /tmp/
RUN apk add \
        freetype \
        freetype-dev \
        libpng \
        libpng-dev \
        libjpeg-turbo \
        libjpeg-turbo-dev \
    && docker-php-ext-configure gd \
        --with-freetype-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && apk del \
        freetype-dev \
        libpng-dev \
        libjpeg-turbo-dev \
    \
    && rm /var/cache/apk/*
RUN cp -rf /tmp/html /var/www/ \
&& cp -f /tmp/flag.sh /flag.sh