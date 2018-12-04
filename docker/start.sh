#!/bin/sh

export BACKEND_HOST=unix:/run/php/php7.2-fpm.sock
confd -onetime -backend env

case $1 in
    start)
	supervisord -n -c /etc/supervisor/supervisord.conf
    ;;
    *)
	$*
    ;;
esac
