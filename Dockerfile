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
ENV PROVISION_CONTEXT "production"

# set working directory
WORKDIR project

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

RUN echo "" >> /etc/apache2/apache2.conf \
    && echo "# Include spreadshare configurations from host machine" >> /etc/apache2/apache2.conf \
    && echo "IncludeOptional spreadshare/*.conf" >> /etc/apache2/apache2.conf

## create directories required by phalcon
RUN mkdir -p /project/system/cache/volt && \
    chown -R $APPLICATION_USER:$APPLICATION_GROUP /project/system/cache && \
    mkdir -p /project/system/log && \
    chown -R $APPLICATION_USER:$APPLICATION_GROUP /project/system/log && \
    mkdir -p /project/system/uploads/userimages && \
    chown -R $APPLICATION_USER:$APPLICATION_GROUP /project/system/uploads/userimages && \
    chown -R $APPLICATION_USER:$APPLICATION_GROUP /project/public

# ---- Dependencies ----
FROM base AS dependencies
# install packages
COPY ./composer.json .
RUN composer install --classmap-authoritative --prefer-dist --no-dev
# copy production packages for later use
RUN cp -R vendor ../prod_vendor
# install ALL packages, including 'dev dependencies' for testing purpose
RUN composer install --classmap-authoritative --prefer-dist

## ---- Test ----
FROM dependencies AS test
COPY . .
RUN ./vendor/phpunit/phpunit/phpunit  --configuration ./phpunit.xml ./app/tests


# ---- Release ----
FROM base AS release
COPY . .
COPY ./docker/apache2 /etc/apache2/spreadshare
COPY docker/app/bin/*.sh /opt/docker/provision/entrypoint.d/
COPY --from=dependencies /prod_vendor ./vendor

