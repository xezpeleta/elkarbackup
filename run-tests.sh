#!/bin/bash

export APP_ENV=test
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

$DIR/bin/console doctrine:database:drop --force
$DIR/bin/console doctrine:database:create
$DIR/bin/console doctrine:migrations:migrate --no-interaction

if [ "$EUID" -ne 0 ]; then
  echo "Checking permissions... sudo required:"
  pwd
  ls composer.json
  sudo --preserve-env $DIR/bin/console elkarbackup:create_admin
else
  echo "Checking permissions... already root!"
  # do not use sudo (GitHub Actions does not like it)
  pwd
  ls composer.json
  $DIR/bin/console elkarbackup:create_admin
fi

mkdir -p /tmp/elkarbackup-tests/uploads
$DIR/bin/console hautelook:fixtures:load --append
$DIR/bin/phpunit "${@:1}"
