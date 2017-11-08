#!/bin/bash

ROOTDIR="$( cd "$( dirname $0 )" && pwd )"
ROOTDIR="$(dirname $ROOTDIR)"

. $ROOTDIR/bin/functions.sh

while getopts ":q" opt; do
  case $opt in
    q)
      echo "Running in quiet mode!" >&2
      QUIET="1"
      ;;
    \?)
      echo "Invalid option: -$OPTARG" >&2
      ;;
  esac
done

if [ ! -e ${ROOTDIR}/app/config/config.ini ]; then
  echo "Creating ${ROOTDIR}/app/config/config.ini"
  cp ${ROOTDIR}/app/config/config.ini.dist ${ROOTDIR}/app/config/config.ini

  test ! -z $QUIET || editFile "${ROOTDIR}/app/config/config.ini"
fi

if [ ! -e ${ROOTDIR}/app/config/Config.php ]; then
  echo "Creating ${ROOTDIR}/app/config/Config.php"
  cp ${ROOTDIR}/app/config/Config.php.dist ${ROOTDIR}/app/config/Config.php

  test ! -z $QUIET || editFile "${ROOTDIR}/app/config/Config.php"
fi

if [ ! -e ${ROOTDIR}/app/config/HybridAuth/Config.php ]; then
  echo "Creating ${ROOTDIR}/app/config/HybridAuth/Config.php"
  cp ${ROOTDIR}/app/config/HybridAuth/Config.php.dist ${ROOTDIR}/app/config/HybridAuth/Config.php

  test ! -z $QUIET || editFile "${ROOTDIR}/app/config/HybridAuth/Config.php"
fi

sudo chmod -R 777 ${ROOTDIR}/system/

echo "Done."
