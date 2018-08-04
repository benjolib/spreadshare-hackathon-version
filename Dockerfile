## Production Dockerfile (Dockerfile)
#
## ---- Base Node ----
#FROM node:8.9.1-alpine AS base
## set working directory
#WORKDIR /hx-auth-service
## install deps
#RUN apk add --no-cache --virtual .gyp python make g++ bash curl
## copy project file
#COPY package.json package-lock.json ./
#COPY ./wait-for-it.sh ./
#COPY ./dockerScript.sh ./
#COPY ./newrelic.js ./
#COPY ./config ./config
#
## create log files
#RUN mkdir -p /var/log/auth-service
#RUN touch /var/log/auth-service/info.log /var/log/auth-service/info.audit.log
#RUN touch /var/log/auth-service/error.log /var/log/auth-service/error.audit.log
#
## ---- Dependencies ----
#FROM base AS dependencies
## install node packages
#RUN npm set progress=false && npm config set depth 0 && npm cache clean --force
#RUN npm install --only=production
## copy production node_modules aside
#RUN cp -R node_modules ../prod_node_modules
## install ALL node_modules, including 'devDependencies'
#RUN npm install
#
## ---- Test ----
#FROM dependencies AS test
#COPY . .
#RUN  npm run test
#
## ---- Build ----
#FROM test AS build
#RUN npm run build
#RUN cp -R build ../build
#
## ---- Release ----
#FROM base AS release
## copy production node_modules
#COPY --from=dependencies /prod_node_modules ./node_modules
## copy build dir
#COPY --from=build /build ./build
## run init script
#ENTRYPOINT ["/hx-auth-service/dockerScript.sh"]

## ---- Base Php ----
FROM phalconphp/php-apache:ubuntu-16.04 AS base
ENV COMPOSER_VERSION 1.5.2

#RUN rm -rf /var/lib/apt/lists/*
RUN apt-get update && apt-get install -y curl
RUN curl -s -f -L -o /tmp/installer.php https://raw.githubusercontent.com/composer/getcomposer.org/da290238de6d63faace0343efbdd5aa9354332c5/web/installer \
    && php -r " \
    \$signature = '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410'; \
    \$hash = hash('SHA384', file_get_contents('/tmp/installer.php')); \
    if (!hash_equals(\$signature, \$hash)) { \
    unlink('/tmp/installer.php'); \
    echo 'Integrity check failed, installer is either corrupt or worse.' . PHP_EOL; \
    exit(1); \
    }" \
    && php /tmp/installer.php --no-ansi --install-dir=/usr/bin --filename=composer --version=${COMPOSER_VERSION} \
    && composer --ansi --version --no-interaction \
    && rm -rf /tmp/* /tmp/.htaccess

RUN mkdir -p  /etc/apache2/spreadshare
RUN echo "" >> /etc/apache2/apache2.conf \
    && echo "# Include spreadshare configurations from host machine" >> /etc/apache2/apache2.conf \
    && echo "IncludeOptional spreadshare/*.conf" >> /etc/apache2/apache2.conf


# ---- Dependencies ----
FROM base AS dependencies
# install packages
COPY ./composer.json /project
WORKDIR /project
RUN composer install --classmap-authoritative --no-dev
# copy production packages for later use
RUN cp -R vendor ../prod_vendor
# RUN ls /project
# RUN ls .
# install ALL packages, including 'dev dependencies' for testing purpose
RUN composer install --classmap-authoritative

## ---- Test ----
FROM dependencies AS test
COPY . .
RUN pwd
RUN ls ./vendor/composer
RUN ./vendor/phpunit/phpunit/phpunit  --configuration ./phpunit.xml ./app/tests --teamcity

# COPY . /project
# RUN composer --working-dir=/project/ install --classmap-authoritative
