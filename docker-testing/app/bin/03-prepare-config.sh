#!/usr/bin/env bash

echo "!!!!!!!!!!!!!!!!!!!!!!!!!! ENV: ${BUILD_ENVIRONMENT}"
echo "Preparing config.."

cp -f /project/application/app/config/Config.php.dist /project/application/app/config/Config.php

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

sed -i -e "s/_HOST_/${HOST}/g" /project/application/app/config/Config.php
sed -i -e "s/_AUTH_CALLBACK_/${AUTH_CALLBACK}/g" /project/application/app/config/Config.php
sed -i -e "s/_WALLET_/${WALLET}/g" /project/application/app/config/Config.php
sed -i -e "s/_ENVIRONMENT_/${BUILD_ENVIRONMENT}/g" /project/application/app/config/Config.php
sed -i -e "s/_MAILGUN_KEY_/${MAILGUN_KEY}/g" /project/application/app/config/Config.php
sed -i -e "s/_CRYPT_KEY_/${CRYPT_KEY}/g" /project/application/app/config/Config.php
sed -i -e "s/_SENTRY_KEY_/${SENTRY_KEY}/g" /project/application/app/config/Config.php
sed -i -e "s/_SLACK_WEBHOOK_/${SLACK_WEBHOOK}/g" /project/application/app/config/Config.php
sed -i -e "s/_FILES_SERVICE_/${FILES_SERVICE}/g" /project/application/app/config/Config.php
sed -i -e "s/_AUTH_DEBUG_/${AUTH_DEBUG}/g" /project/application/app/config/Config.php
sed -i -e "s/_TWITTER_ID_/${TWITTER_ID}/g" /project/application/app/config/Config.php
sed -i -e "s/_TWITTER_KEY_/${TWITTER_KEY}/g" /project/application/app/config/Config.php
sed -i -e "s/_TWITTER_SECRET_/${TWITTER_SECRET}/g" /project/application/app/config/Config.php
sed -i -e "s/_GOOGLE_ID_/${GOOGLE_ID}/g" /project/application/app/config/Config.php
sed -i -e "s/_GOOGLE_SECRET_/${GOOGLE_SECRET}/g" /project/application/app/config/Config.php
sed -i -e "s/_FACEBOOK_ID_/${FACEBOOK_ID}/g" /project/application/app/config/Config.php
sed -i -e "s/_FACEBOOK_SECRET_/${FACEBOOK_SECRET}/g" /project/application/app/config/Config.php

echo "Done."