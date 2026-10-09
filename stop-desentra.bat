@echo off
title Hentikan Server Desentra
echo Menghentikan proses server Desentra & MySQL...
taskkill /F /IM php.exe /T 2>nul
taskkill /F /IM mysqld.exe /T 2>nul
echo [OK] Server berhasil dihentikan.
pause
