#!/usr/bin/env bash
set -e

echo "========================================================"
echo "          MENYALAKAN DESENTRA DOCKER ENVIRONMENT       "
echo "========================================================"
echo ""

docker compose up -d --build

echo ""
echo "========================================================"
echo "🚀 Layanan aktif:"
echo "   - Web App Warga : http://localhost:8080"
echo "   - Portal Admin  : http://localhost:8080/admin/login"
echo "   - phpMyAdmin    : http://localhost:8081"
echo ""
echo "📜 Melihat log: docker compose logs -f"
echo "🛑 Menghentikan : ./stop-desentra.sh"
echo "========================================================"
