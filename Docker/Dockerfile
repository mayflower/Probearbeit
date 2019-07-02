# Building the base image
FROM php:7.3-fpm-stretch as php_base

RUN echo ">>> running BASE commands"

COPY Docker/php.ini /usr/local/etc/php/

RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -

RUN apt-get update && apt-get install -y \
    $PHPIZE_DEPS \
    build-essential \
    apt-transport-https \
    git \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libssl-dev \
    nginx \
    libmemcached-dev \
    nodejs \
    mysql-client \
    openssh-client \
    supervisor \
    unzip \
    vim \
    wget \
    && docker-php-ext-configure gd \
         --with-freetype-dir=/usr/include/ \
         --with-png-dir=/usr/include/ \
         --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install pdo pdo_mysql mysqli calendar pcntl opcache gd intl \
    && pecl install memcached \
    && docker-php-ext-enable memcached

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --version

RUN npm install -g yarn

ENV PATH /usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin

COPY Docker/scripts/stop-supervisor.sh /usr/bin/stop-supervisor.sh
COPY Docker/www.conf /usr/local/etc/php-fpm.d/www.conf

# make scripts executable
RUN chmod 755 /usr/bin/stop-supervisor.sh

ENV ENVIRONMENT development

# XDEBUG
ARG XDEBUGINI_PATH=/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN echo "Europe/Berlin" > /etc/timezone ; \
    dpkg-reconfigure -f noninteractive tzdata ; \
    pecl install xdebug ; \
    docker-php-ext-enable xdebug; \
    echo "error_reporting = E_ALL" >> ${XDEBUGINI_PATH} ; \
    echo "display_startup_errors = On" >> ${XDEBUGINI_PATH} ; \
    echo "display_errors = On" >> ${XDEBUGINI_PATH} ; \
    echo "xdebug.remote_enable=on" >> ${XDEBUGINI_PATH} ; \
    echo "xdebug.remote_autostart=on" >> ${XDEBUGINI_PATH} ; \
    echo "xdebug.idekey=\"PHPSTORM\"" >> ${XDEBUGINI_PATH} ; \
    echo "xdebug.remote_port=9001" >> ${XDEBUGINI_PATH} ; \
    apt-get clean ; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* ;

# aliases
ADD Docker/aliases.sh /root/.bashrc

# Linux
# RUN echo "xdebug.remote_host=172.17.0.1" >> ${XDEBUGINI_PATH}
# RUN echo "alias debug='export PHP_IDE_CONFIG=\"serverName=lektor.local\" && export XDEBUG_CONFIG=\"remote_enable=1 remote_mode=req remote_port=9001 remote_host=172.17.0.1 remote_connect_back=0\"'" >> ~/.bashrc;

# Mac
RUN echo "xdebug.remote_host="`getent hosts docker.for.mac.localhost | awk '{ print $1 }'` >> ${XDEBUGINI_PATH}
RUN echo "alias debug='export PHP_IDE_CONFIG=\"serverName=lektor.local\" && export XDEBUG_CONFIG=\"remote_enable=1 remote_mode=req remote_port=9001 remote_host=192.168.56.1 remote_connect_back=0\"'" >> ~/.bashrc;


# copy stuff into image
COPY Docker/sf.conf /etc/nginx/conf.d/default.conf
COPY Docker/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY Docker/supervisord-development.conf /etc/supervisor/conf.d/supervisord.conf
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* ;

WORKDIR /var/www/probearbeit
CMD /usr/bin/supervisord