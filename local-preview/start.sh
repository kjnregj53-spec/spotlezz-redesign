#!/usr/bin/env bash
# Starts the local Spotlezz WordPress preview: MariaDB (isolated data dir,
# port 3307) + PHP built-in server (port 8890). Run from Git Bash.
set -e

DATADIR="/c/Users/sdrbk/AppData/Local/Temp/claude/D--spotlezz-redesign-final/7037d0e8-ae2c-4734-b003-cce3e52ed482/scratchpad/wp-preview-mysql-data"
PREVIEW_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

echo "Starting MariaDB (port 3307)..."
"/c/Program Files/MariaDB 12.3/bin/mariadbd.exe" \
  --datadir="$(cygpath -w "$DATADIR")" \
  --port=3307 \
  --bind-address=127.0.0.1 \
  --pid-file="$(cygpath -w "$DATADIR")\mariadb.pid" \
  > "$PREVIEW_DIR/mariadb-server.log" 2>&1 &
echo "MariaDB PID: $!"
sleep 3

echo "Starting PHP built-in server (port 8890)..."
cd "$PREVIEW_DIR/wordpress"
php -S localhost:8890 > "$PREVIEW_DIR/php-server.log" 2>&1 &
echo "PHP server PID: $!"
sleep 1

echo ""
echo "Preview ready: http://localhost:8890/"
echo "Admin: http://localhost:8890/wp-admin/  (user: previewadmin)"
echo "Run stop.sh to shut both down."
