#!/bin/bash
set -e

echo $GZCTF_FLAG > /flag

export GZCTF_FLAG=not_flag
GZCTF_FLAG=not_flag

chmod 777 -R /var/www/html

mysql -e "source /var/www/html/kasilab.sql;"