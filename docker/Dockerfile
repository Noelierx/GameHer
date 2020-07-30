FROM phpdockerio/php73-fpm:latest

RUN apt-get update \
    && apt-get install -y \
    coreutils \
    php7.3-fpm \
    php7.3-bcmath \
    php7.3-curl \
    php7.3-json \
    php7.3-intl \
    php7.3-mbstring \
    php7.3-opcache \
    php7.3-mysql \
    php7.3-sqlite3 \
    php7.3-xml \
    php7.3-xdebug \
    php7.3-zip \
    make \
    git \
    curl

RUN echo "$(curl -sS https://composer.github.io/installer.sig) -" > composer-setup.php.sig \
        && curl -sS https://getcomposer.org/installer | tee composer-setup.php | sha384sum -c composer-setup.php.sig \
        && php composer-setup.php && rm composer-setup.php* \
        && chmod +x composer.phar && mv composer.phar /usr/bin/composer

RUN apt-get update -yq \
    && apt-get install curl gnupg -yq \
    && curl -sL https://deb.nodesource.com/setup_12.x | bash \
    && apt-get install nodejs -yq

COPY symfony.ini /etc/php7.3/conf.d/
COPY symfony.ini /etc/php7.3/cli/conf.d/
COPY symfony.pool.conf /etc/php7.3/php-fpm.d/

CMD ["php-fpm7.3", "-F"]

EXPOSE 9001
