#!/bin/sh

set -e

export BACKEND_HOST=unix:/run/php/php7.2-fpm.sock
confd -onetime -backend env
sed -i /etc/php/7.2/fpm/pool.d/www.conf -e 's/.*clear_env.*/clear_env = no/'
chown www-data.www-data /var/www/app/storage/app/requests

case $1 in
    start)
	supervisord -n -c /etc/supervisor/supervisord.conf
    ;;
    *)
	$*
    ;;
esac
