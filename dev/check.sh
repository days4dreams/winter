#!/usr/bin/env bash
# Checks the Winter's Nook site before it's uploaded: every PHP file must be valid, and
# every page in dev/urls.txt must load with no PHP errors or warnings.
# Run by GitHub Actions; you can also run it yourself: bash dev/check.sh
set -euo pipefail
cd "$(git rev-parse --show-toplevel)"

echo "Checking PHP syntax..."
git ls-files '*.php' | xargs -n1 php -l > /dev/null

echo "Checking pages..."
PORT=8099
php -d display_errors=1 -d error_reporting=-1 -S 127.0.0.1:$PORT router.php > /tmp/winter-check.log 2>&1 &
SERVER=$!
trap 'kill $SERVER 2>/dev/null' EXIT
sleep 1

failed=0
check() { # url, expected status
  body=$(curl -s -w '\n%{http_code}' "http://127.0.0.1:$PORT$1")
  code=$(tail -n1 <<< "$body")
  if [ "$code" != "$2" ]; then
    echo "  FAIL $1 returned $code (expected $2)"; failed=1
  elif grep -qiE '(Deprecated|Warning|Notice|Fatal error|Parse error)</?b?>?:' <<< "$body"; then
    echo "  FAIL $1 shows a PHP message:"; grep -iE 'Deprecated|Warning|Notice|Fatal error' <<< "$body" | head -3; failed=1
  else
    echo "  ok   $1"
  fi
}
while read -r url; do [ -n "$url" ] && check "$url" 200; done < dev/urls.txt
check /sitemap.xml 200
check /robots.txt 200
check /this-page-does-not-exist 404
check /the-guide/no-such-post 404
check /includes/config.php 404   # private folders stay private
check /content/faqs.md 404

if grep -qiE 'Deprecated|Warning|Notice|Fatal' /tmp/winter-check.log; then
  echo "PHP reported problems:"; grep -iE 'Deprecated|Warning|Notice|Fatal' /tmp/winter-check.log | head; failed=1
fi
exit $failed
