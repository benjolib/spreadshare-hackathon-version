#!/usr/bin/env bash

echo "Updating composer dependencies (for $PROVISION_CONTEXT).."

# Need to view what commands are to be run
set -x

# Give composer more time to fetch packages
export COMPOSER_PROCESS_TIMEOUT=7200

if [ $PROVISION_CONTEXT != "development" ]; then
	composer --working-dir=/application/ install --no-dev --classmap-authoritative
else
    composer --working-dir=/application/ install --classmap-authoritative
fi

echo "Completed - composer dependencies (for $PROVISION_CONTEXT)"
