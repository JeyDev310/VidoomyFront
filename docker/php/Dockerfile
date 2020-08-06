# ./docker/php/Dockerfile
FROM php:7.4-fpm

RUN pecl install apcu

RUN apt-get update && \
apt-get install -y \
libzip-dev libpq-dev librabbitmq-dev vim

ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="1" \
    PHP_OPCACHE_MAX_ACCELERATED_FILES="10000" \
    PHP_OPCACHE_MEMORY_CONSUMPTION="192" \
    PHP_OPCACHE_MAX_WASTED_PERCENTAGE="10"

RUN docker-php-ext-install zip opcache
RUN pecl install amqp
RUN docker-php-ext-enable apcu amqp

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e613307e16318854d24ae64f26d17af3ef0bf7cfb710ca74755a') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --filename=composer \
    && php -r "unlink('composer-setup.php');" \
    && mv composer /usr/local/bin/composer

WORKDIR /usr/src/app

COPY docker/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY docker/php/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf

COPY . /usr/src/app

RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin

RUN /bin/bash -c 'chmod -R 777 /usr/src/app/var/cache'

RUN \
  curl -L https://download.newrelic.com/php_agent/release/newrelic-php5-9.12.0.268-linux.tar.gz | tar -C /tmp -zx && \
  export NR_INSTALL_USE_CP_NOT_LN=1 && \
  export NR_INSTALL_SILENT=1 && \
  /tmp/newrelic-php5-*/newrelic-install install && \
  rm -rf /tmp/newrelic-php5-* /tmp/nrinstall* && \
  sed -i \
      -e 's/"REPLACE_WITH_REAL_KEY"/"0c8924f421abc5b10e3d732d2d2c00a06c7eNRAL"/' \
      -e 's/newrelic.appname = "PHP Application"/newrelic.appname = "Vidoomy RTB Front server"/' \
      -e 's/;newrelic.daemon.app_connect_timeout =.*/newrelic.daemon.app_connect_timeout=15s/' \
      -e 's/;newrelic.daemon.start_timeout =.*/newrelic.daemon.start_timeout=5s/' \
      /usr/local/etc/php/conf.d/newrelic.ini

