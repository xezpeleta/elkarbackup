#!/usr/bin/env bash
set -e

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

docker-compose --f "$DIR/docker-compose.yml" --profile donotstart build
docker-compose --f "$DIR/docker-compose.yml" up --exit-code-from elkarbackup
