#!/bin/sh
set -e

# Render passes PORT at runtime (default 10000).
: "${PORT:=10000}"

###############################################################################
# Render nginx site conf from template (must listen on $PORT)
###############################################################################

envsubst '$PORT' < /etc/nginx/templates/site.conf.template > /etc/nginx/conf.d/site.conf

# Ensure nginx temp dirs exist
mkdir -p \
  /tmp/nginx/body \
  /tmp/nginx/proxy_temp \
  /tmp/nginx/fastcgi_temp \
  /tmp/nginx/uwsgi_temp \
  /tmp/nginx/scgi_temp

chown -R www-data:www-data /tmp/nginx

# Start supervisor (manages php-fpm + nginx)
exec /usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf
