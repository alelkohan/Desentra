#!/usr/bin/env bash
set -e

echo "========================================================"
echo "          MENGHENTIKAN DESENTRA DOCKER ENVIRONMENT      "
echo "========================================================"
echo ""

docker compose down

echo ""
echo "✅ Seluruh kontainer Desentra telah dihentikan."
