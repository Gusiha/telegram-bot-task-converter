#!/bin/sh

if [ "$XDEBUG" = "1" ]; then
    # debug для IDE
    echo "xdebug.mode=debug,develop" > /usr/local/etc/php/conf.d/xdebug-settings.ini
    echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug-settings.ini
    echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug-settings.ini
    echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/xdebug-settings.ini
    echo "xdebug.idekey=docker" >> /usr/local/etc/php/conf.d/xdebug-settings.ini
fi

exec "$@"
