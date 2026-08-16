#!/usr/bin/env bash
# Stops the local Spotlezz WordPress preview (MariaDB + PHP server).
# Only targets the isolated preview processes by image name — does not
# touch any other MySQL/MariaDB/PHP instance on the machine.
echo "Stopping PHP built-in server..."
taskkill //F //IM php.exe 2>&1 || true

echo "Stopping MariaDB preview instance..."
taskkill //F //IM mariadbd.exe 2>&1 || true

echo "Stopped."
