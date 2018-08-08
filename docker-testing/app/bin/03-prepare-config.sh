#!/usr/bin/env bash

echo "!!!!!!!!!!!!!!!!!!!!!!!!!! ENV: ${BUILD_ENVIRONMENT}"
echo "Preparing config.."

cp -f /application/app/config/Config.php.dist /application/app/config/Config.php

HOST=$(sed 's/[&/\]/\\&/g' <<< "${HOST}")
AUTH_CALLBACK=$(sed 's/[&/\]/\\&/g' <<< "${AUTH_CALLBACK}")
WALLET=$(sed 's/[&/\]/\\&/g' <<< "${WALLET}")
BUILD_ENVIRONMENT=$(sed 's/[&/\]/\\&/g' <<< "${BUILD_ENVIRONMENT}")
MAILGUN_KEY=$(sed 's/[&/\]/\\&/g' <<< "${MAILGUN_KEY}")
CRYPT_KEY=$(sed 's/[&/\]/\\&/g' <<< "${CRYPT_KEY}")
SENTRY_KEY=$(sed 's/[&/\]/\\&/g' <<< "${SENTRY_KEY}")
SLACK_WEBHOOK=$(sed 's/[&/\]/\\&/g' <<< "${SLACK_WEBHOOK}")
FILES_SERVICE=$(sed 's/[&/\]/\\&/g' <<< "${FILES_SERVICE}")
AUTH_DEBUG=$(sed 's/[&/\]/\\&/g' <<< "${AUTH_DEBUG}")
TWITTER_ID=$(sed 's/[&/\]/\\&/g' <<< "${TWITTER_ID}")
TWITTER_KEY=$(sed 's/[&/\]/\\&/g' <<< "${TWITTER_KEY}")
TWITTER_SECRET=$(sed 's/[&/\]/\\&/g' <<< "${TWITTER_SECRET}")
TWITTER_SECRET=$(sed 's/[&/\]/\\&/g' <<< "${TWITTER_SECRET}")
GOOGLE_ID=$(sed 's/[&/\]/\\&/g' <<< "${GOOGLE_ID}")
GOOGLE_SECRET=$(sed 's/[&/\]/\\&/g' <<< "${GOOGLE_SECRET}")
FACEBOOK_ID=$(sed 's/[&/\]/\\&/g' <<< "${FACEBOOK_ID}")
FACEBOOK_SECRET=$(sed 's/[&/\]/\\&/g' <<< "${FACEBOOK_SECRET}")
MAIL_DISPATCHER_URL=$(sed 's/[&/\]/\\&/g' <<< "${MAIL_DISPATCHER_URL}")
MAIL_DISPATCHER_API_KEY=$(sed 's/[&/\]/\\&/g' <<< "${MAIL_DISPATCHER_API_KEY}")
SUBSCRIPTION_SERVICE_URL=$(sed 's/[&/\]/\\&/g' <<< "${SUBSCRIPTION_SERVICE_URL}")
SUBSCRIPTION_SERVICE_API_KEY=$(sed 's/[&/\]/\\&/g' <<< "${SUBSCRIPTION_SERVICE_API_KEY}")

sed -i -e "s/_HOST_/${HOST}/g" /application/app/config/Config.php
sed -i -e "s/_AUTH_CALLBACK_/${AUTH_CALLBACK}/g" /application/app/config/Config.php
sed -i -e "s/_WALLET_/${WALLET}/g" /application/app/config/Config.php
sed -i -e "s/_ENVIRONMENT_/${BUILD_ENVIRONMENT}/g" /application/app/config/Config.php
sed -i -e "s/_MAILGUN_KEY_/${MAILGUN_KEY}/g" /application/app/config/Config.php
sed -i -e "s/_CRYPT_KEY_/${CRYPT_KEY}/g" /application/app/config/Config.php
sed -i -e "s/_SENTRY_KEY_/${SENTRY_KEY}/g" /application/app/config/Config.php
sed -i -e "s/_SLACK_WEBHOOK_/${SLACK_WEBHOOK}/g" /application/app/config/Config.php
sed -i -e "s/_FILES_SERVICE_/${FILES_SERVICE}/g" /application/app/config/Config.php
sed -i -e "s/_AUTH_DEBUG_/${AUTH_DEBUG}/g" /application/app/config/Config.php
sed -i -e "s/_TWITTER_ID_/${TWITTER_ID}/g" /application/app/config/Config.php
sed -i -e "s/_TWITTER_KEY_/${TWITTER_KEY}/g" /application/app/config/Config.php
sed -i -e "s/_TWITTER_SECRET_/${TWITTER_SECRET}/g" /application/app/config/Config.php
sed -i -e "s/_GOOGLE_ID_/${GOOGLE_ID}/g" /application/app/config/Config.php
sed -i -e "s/_GOOGLE_SECRET_/${GOOGLE_SECRET}/g" /application/app/config/Config.php
sed -i -e "s/_FACEBOOK_ID_/${FACEBOOK_ID}/g" /application/app/config/Config.php
sed -i -e "s/_FACEBOOK_SECRET_/${FACEBOOK_SECRET}/g" /application/app/config/Config.php
sed -i -e "s/_MAIL_DISPATCHER_URL_/${MAIL_DISPATCHER_URL}/g" /application/app/config/Config.php
sed -i -e "s/_MAIL_DISPATCHER_API_KEY_/${MAIL_DISPATCHER_API_KEY}/g" /application/app/config/Config.php
sed -i -e "s/_SUBSCRIPTION_SERVICE_URL_/${SUBSCRIPTION_SERVICE_URL}/g" /application/app/config/Config.php
sed -i -e "s/_SUBSCRIPTION_SERVICE_API_KEY_/${SUBSCRIPTION_SERVICE_API_KEY}/g" /application/app/config/Config.php

echo "Done."