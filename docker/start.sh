#!/bin/sh

confd -onetime -backend env

case $1 in
    start)
	supervisord -n -c /etc/supervisor/supervisord.conf
    ;;
    *)
	$*
    ;;
esac
