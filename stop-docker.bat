@echo off
title Stop Desentra Docker Server
echo ========================================================
echo        MENGHENTIKAN DESENTRA DOCKER ENVIRONMENT
echo ========================================================
echo.

docker compose down

echo.
echo Seluruh kontainer Desentra telah dihentikan.
echo.
pause
