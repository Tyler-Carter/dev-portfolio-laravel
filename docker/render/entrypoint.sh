#!/bin/sh
set -e

# Render passes PORT at runtime (default 10000).
: "${PORT:=10000}"

###############################################################################
# Render Secret File -> Laravel .env
#
# Render Docker secret files are available at runtime at:
#   /etc/secrets/<filename>
#
# Create a Render "Secret File" and set its Filename to match SECRET_ENV_FILENAME.
###############################################################################

: "${SECRET_ENV_FILENAME:=.env}"
: "${ALLOW_MISSING_SECRET_ENV:=0}"

SECRET_ENV_PATH="/etc/secrets/${SECRET_ENV_FILENAME}"
LARAVEL_ENV_PATH="/var/www/html/.env"

if [ -f "${SECRET_ENV_PATH}" ]; then
  echo "Found Render secret file: ${SECRET_ENV_PATH}"
  echo "Copying to Laravel .env: ${LARAVEL_ENV_PATH}"

  cp "${SECRET_ENV_PATH}" "${LARAVEL_ENV_PATH}"

  # Restrictive permissions: readable by php-fpm worker group, not world-readable.
  chown root:www-data "${LARAVEL_ENV_PATH}" || true
  chmod 0640 "${LARAVEL_ENV_PATH}" || true
else
  if [ "${ALLOW_MISSING_SECRET_ENV}" = "1" ]; then
    echo "WARNING: Render secret file not found at ${SECRET_ENV_PATH}; continuing because ALLOW_MISSING_SECRET_ENV=1" >&2
  else
    echo "ERROR: Render secret file not found at ${SECRET_ENV_PATH}" >&2
    echo "       Create a Render Secret File named '${SECRET_ENV_FILENAME}' or set SECRET_ENV_FILENAME accordingly." >&2
    exit 1
  fi
fi

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
