#!/usr/bin/env bash
#
# Uploads the Winter's Nook website to Krystal over SFTP. Run by GitHub Actions
# (.github/workflows/deploy.yml); you don't normally run it yourself.
#
# How it stays safe and quick:
#  - It keeps a list of every file it uploaded, with a fingerprint of each,
#    in .deploy-manifest on the server. Each run uploads only files that are
#    new or changed since then.
#  - It only ever deletes files that it uploaded itself and that have since
#    been removed from the repo. Anything else on the server is never touched.
#  - It refuses to upload anywhere but the subdomain's own folder, so it can
#    never touch the main site in public_html.
#  - .htaccess goes up last, so the new address rules only switch on once
#    the pages they point to are in place.
#
# Settings (from GitHub secrets / variables):
#   SFTP_HOST, SFTP_USER, SFTP_PASSWORD   required
#   SFTP_PORT        default 722 (Krystal's SFTP port)
#   REMOTE_DIR       required: the subdomain's folder, e.g. winter.stayingseason.com
#   SFTP_KNOWN_HOSTS optional but recommended: the server's SSH key, so the
#                    upload can only go to the real Krystal server
#   DRY_RUN=1        list what would change without uploading anything

set -euo pipefail

: "${SFTP_HOST:?SFTP_HOST secret is missing}"
: "${SFTP_USER:?SFTP_USER secret is missing}"
: "${SFTP_PASSWORD:?SFTP_PASSWORD secret is missing}"
PORT="${SFTP_PORT:-722}"
REMOTE="${REMOTE_DIR:-}"
REMOTE="${REMOTE%/}"

# Safety stop: this site must never be uploaded into the main site's folder
# (or the home folder), where its upload record could clash with the main
# site's and its clean-up could remove the main site's files.
case "$REMOTE" in
  ""|"."|"/"|"~"|public_html|public_html/*|/*|*..*)
    echo "::error::REMOTE_DIR is '$REMOTE'. It must be the subdomain's own folder, e.g. winter.stayingseason.com (not public_html). Nothing was uploaded." >&2
    exit 1 ;;
esac

cd "$(git rev-parse --show-toplevel)"
WORK="$(mktemp -d)"
trap 'rm -rf "$WORK"' EXIT

# --- 1. Which files go to the server -------------------------------------
# Everything in the repo except developer files.
{
  git ls-files | grep -vE '^(\.git|\.github/|dev/|README\.md$|router\.php$)'
  # The private settings file is written by the workflow, not kept in git.
  if [ -f includes/private.php ]; then echo includes/private.php; fi
} | sort > "$WORK/files"

# Refuse odd file names (spaces, quotes...) rather than risk a bad upload.
if grep -vE '^[A-Za-z0-9._/@-]+$' "$WORK/files"; then
  echo "The file names above contain characters this script doesn't handle." >&2
  echo "Rename them using letters, numbers, hyphens, dots and underscores." >&2
  exit 1
fi

# Fingerprint every file: "<sha256>  <path>"
xargs sha256sum < "$WORK/files" > "$WORK/new-manifest"

# --- 2. Connect -----------------------------------------------------------
export LFTP_PASSWORD="$SFTP_PASSWORD"
SSH_OPTS="-a -x -o ConnectTimeout=30"
if [ -n "${SFTP_KNOWN_HOSTS:-}" ]; then
  printf '%s\n' "$SFTP_KNOWN_HOSTS" > "$WORK/known_hosts"
  SSH_OPTS="$SSH_OPTS -o StrictHostKeyChecking=yes -o UserKnownHostsFile=$WORK/known_hosts"
else
  echo "::warning::SFTP_KNOWN_HOSTS is not set, so the server's identity isn't checked. See README."
  SSH_OPTS="$SSH_OPTS -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null"
fi

lftp_run() { # runs the lftp commands in file $1
  lftp -c "set net:max-retries 3; set net:timeout 30; set cmd:fail-exit yes; set cmd:move-background no;
           set sftp:connect-program 'ssh $SSH_OPTS';
           open --env-password -u '$SFTP_USER' -p $PORT sftp://$SFTP_HOST;
           source $1"
}

# Check the login and folder before doing anything else.
echo "cd $REMOTE" > "$WORK/check.lftp"
if ! lftp_run "$WORK/check.lftp"; then
  echo "::error::Couldn't log in to $SFTP_HOST:$PORT or open the folder '$REMOTE'. Check the SFTP secrets." >&2
  exit 1
fi

# --- 3. What changed since the last upload --------------------------------
echo "get $REMOTE/.deploy-manifest -o $WORK/old-manifest" > "$WORK/fetch.lftp"
if ! lftp_run "$WORK/fetch.lftp" 2>/dev/null; then
  echo "No previous upload record found: this is the first upload, so every file will be sent."
  : > "$WORK/old-manifest"
fi

# Changed or new = lines (fingerprint + path) not in the old record.
comm -13 <(sort "$WORK/old-manifest") <(sort "$WORK/new-manifest") | awk '{print $2}' > "$WORK/upload"
# Removed = paths in the old record that are no longer in the repo.
comm -23 <(awk '{print $2}' "$WORK/old-manifest" | sort -u) "$WORK/files" > "$WORK/delete"

echo "Files to upload: $(wc -l < "$WORK/upload")"
sed 's/^/  + /' "$WORK/upload"
echo "Files to delete: $(wc -l < "$WORK/delete")"
sed 's/^/  - /' "$WORK/delete"

if [ "${DRY_RUN:-0}" = "1" ]; then
  echo "Dry run: nothing was uploaded."
  exit 0
fi

# --- 4. Upload --------------------------------------------------------------
{
  # Folders first, then files (.htaccess last), then deletions, then the record.
  { grep '/' "$WORK/upload" || true; } | xargs -r -n1 dirname | sort -u \
    | sed "s#.*#mkdir -p -f $REMOTE/&; chmod 755 $REMOTE/&#"
  # chmod 644: readable by the web server, writable only by you (some hosts
  # refuse to run PHP files that others can write to).
  { grep -vx '.htaccess' "$WORK/upload" || true; } | sed "s#.*#put & -o $REMOTE/&; chmod 644 $REMOTE/&#"
  { grep -x '.htaccess' "$WORK/upload" || true; } | sed "s#.*#put & -o $REMOTE/&; chmod 644 $REMOTE/&#"
  sed "s#.*#rm -f $REMOTE/&#" "$WORK/delete"
  echo "put $WORK/new-manifest -o $REMOTE/.deploy-manifest"
} > "$WORK/upload.lftp"

lftp_run "$WORK/upload.lftp"
echo "Upload complete."
