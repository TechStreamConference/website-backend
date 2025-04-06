#! /bin/bash

if [ ! -d "./vendor" ]; then
  echo "'vendor' not found in volume, restoring from image..."
  cp -v -r /vendor.bak ./vendor
fi

exec "$@"
