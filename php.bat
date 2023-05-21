#!/bin/sh
cd ..
docker compose exec app php "$@"
return $?
