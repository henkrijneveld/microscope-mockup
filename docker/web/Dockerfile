# Building this image: docker build -t phpapache .
#
# fullfledge run example: docker run -p 80:80 --link sqlinstance:mysql -e XDEBUG_CONFIG="remote_host=192.168.3.10" -v ~/test/Site:/var/www/html --rm -it  phpapache
# adjust ip address to address of machine with PHPSTorm running
# adjust volume to volume of machine where docker is running 

# connecting to database, add: --link <name of mysql container>:mysql
# use mysql as database server name

# FROM php:5.4-apache
# FROM php:5.6-apache
FROM php:7.3-apache
MAINTAINER Henk Rijneveld <henk@henkrijneveld.nl>

RUN apt-get update && \
	apt-get upgrade -y && \
    apt-get install -y nano

RUN pecl install xdebug-2.9.8
RUN docker-php-ext-enable xdebug
RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/php.ini

RUN rm /etc/apt/preferences.d/no-debian-php

RUN docker-php-ext-install mysqli
RUN docker-php-ext-enable mysqli

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-enable pdo_mysql

RUN apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd zip

COPY ssl-cert-snakeoil.pem /etc/ssl/certs/ssl-cert-snakeoil.pem
COPY ssl-cert-snakeoil.key /etc/ssl/private/ssl-cert-snakeoil.key

## Install Perl
RUN apt-get -y install \
    libapache2-mod-perl2 \
    perl

RUN a2enmod rewrite \
    && a2ensite default-ssl \
    && a2enmod ssl \
    && a2enmod headers \
    && a2enmod perl \
    && a2enmod expires

RUN a2enmod cgid

# htaccess security
ARG adminid
ARG adminpw
ARG userid
ARG userpw
RUN htpasswd -bc /etc/apache2/.htpasswd $adminid $adminpw \
    && htpasswd -b /etc/apache2/.htpasswd $userid $userpw \
    && sed -i "s/AllowOverride None/AllowOverride All/g" /etc/apache2/apache2.conf

# dedicated changes to php.ini
RUN echo upload_max_filesize = 32M >> /usr/local/etc/php/php.ini
RUN echo post_max_size = 32M >> /usr/local/etc/php/php.ini
RUN echo max_execution_time = 600 >> /usr/local/etc/php/php.ini
RUN echo memory_limit = 768M >> /usr/local/etc/php/php.ini

RUN echo display_startup_errors = On >> /usr/local/etc/php/php.ini
RUN echo display errors = On >> /usr/local/etc/php/php.ini
RUN echo log_errors = On >> /usr/local/etc/php/php.ini
RUN echo "error_reporting = E_ALL | E_STRICT" >> /usr/local/etc/php/php.ini
RUN echo error_log = /var/log/apache2/error.log >> /usr/local/etc/php/php.ini

# dedicated apache changes
ARG loglevel

RUN echo TimeOut 600 >> /etc/apache2/apache2.conf \
    && echo LogLevel $loglevel >> /etc/apache2/apache2.conf

# Change www-data user to match the host system UID and GID and chown www directory
ARG uiduser
ARG giduser
RUN usermod --non-unique --uid $uiduser www-data \
  && groupmod --non-unique --gid $giduser www-data \
  && chown -R www-data:www-data /var/www
