#!/usr/bin/env bash
set -euo pipefail

# Required env vars:
#   RENDER_API_KEY
#   RENDER_SERVICE_ID
#   Optional:
#   RENDER_JOB_PLAN_ID (e.g., plan-srv-006) - see Render docs for plan IDs
#
# This script:
#  1) Creates a Render one-off job that runs Laravel migrations
#  2) Polls job status until succeeded/failed
#
# Notes:
# - A Render one-off job uses the same build artifact and configuration as its base service,
#   including the base service's environment variables (e.g., DATABASE_URL). :contentReference[oaicite:2]{index=2}
# - Laravel can read the DB connection from the `url` config via DB_URL / DATABASE_URL. :contentReference[oaicite:3]{index=3}

require_env() {
  local name="$1"
  if [[ -z "${!name:-}" ]]; then
    echo "Missing required env var: ${name}" >&2
    exit 1
  fi
}

require_env "RENDER_API_KEY"
require_env "RENDER_SERVICE_ID"

API_BASE="https://api.render.com/v1/services/${RENDER_SERVICE_ID}"
AUTH_HEADER="Authorization: Bearer ${RENDER_API_KEY}"

# Command runs inside your container image, which (per your Dockerfile) has:
# - WORKDIR /var/www/html
# - artisan present at /var/www/html/artisan
# We'll use sh -lc for portability.
#
# IMPORTANT:
# - Do NOT override DB_URL here.
# - Rely on the base service env var DATABASE_URL that you confirmed is set in Render.
START_COMMAND=$'sh -lc \'cd /var/www/html && php artisan migrate --force\''

CREATE_BODY="$(jq -n --arg startCommand "$START_COMMAND" '
  {startCommand: $startCommand}
')"

# Optional planId override if you set RENDER_JOB_PLAN_ID
if [[ -n "${RENDER_JOB_PLAN_ID:-}" ]]; then
  CREATE_BODY="$(jq --arg planId "$RENDER_JOB_PLAN_ID" '. + {planId: $planId}' <<<"$CREATE_BODY")"
fi

echo "Creating Render one-off job for migrations..."
CREATE_RESP="$(curl -sS -X POST "${API_BASE}/jobs" \
  -H "$AUTH_HEADER" \
  -H "Content-Type: application/json" \
  --data-raw "$CREATE_BODY")"

JOB_ID="$(jq -r '.id // empty' <<<"$CREATE_RESP")"
if [[ -z "$JOB_ID" ]]; then
  echo "Failed to create job. Response:" >&2
  echo "$CREATE_RESP" >&2
  exit 1
fi

echo "Created job: $JOB_ID"
echo "Polling job status..."

while true; do
  JOB_RESP="$(curl -sS -X GET "${API_BASE}/jobs/${JOB_ID}" -H "$AUTH_HEADER")"
  STATUS="$(jq -r '.status // empty' <<<"$JOB_RESP")"

  if [[ -z "$STATUS" ]]; then
    echo "Unable to read job status. Response:" >&2
    echo "$JOB_RESP" >&2
    exit 1
  fi

  echo "Job status: $STATUS"

  case "$STATUS" in
    succeeded)
      echo "Migrations job succeeded."
      exit 0
      ;;
    failed|canceled)
      echo "Migrations job did not succeed. Final response:" >&2
      echo "$JOB_RESP" >&2
      exit 1
      ;;
    *)
      # queued / running / etc.
      sleep 5
      ;;
  esac
done
