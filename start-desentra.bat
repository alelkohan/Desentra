@echo off
title Desentra Local Server
echo ========================================================
echo         MENYALAKAN SERVER DESENTRA (PORT 8080)
echo ========================================================
echo.

set PHP_PATH=C:\laragon\bin\php\php-8.3.33-Win32-vs16-x64\php.exe
set MYSQL_PATH=C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysqld.exe
set MYSQL_INI=C:\laragon\bin\mysql\mysql-8.4.3-winx64\my.ini

REM 1. Cek & Jalankan MySQL di background
tasklist /FI "IMAGENAME eq mysqld.exe" 2>NUL | find /I /N "mysqld.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo [OK] MySQL Service sudah berjalan.
) else (
    echo [..] Menyalakan MySQL Service...
    start /B "" "%MYSQL_PATH%" --defaults-file="%MYSQL_INI%"
    timeout /t 2 /nobreak >nul
    echo [OK] MySQL berhasil dinyalakan.
)

REM 2. Buka Browser Otomatis
echo [..] Membuka browser ke http://localhost:8080 ...
start http://localhost:8080

REM 3. Jalankan Web Server CodeIgniter 4
echo.
echo ========================================================
echo  Server aktif di: http://localhost:8080
echo  Tekan [Ctrl + C] untuk menghentikan server.
echo ========================================================
echo.
"%PHP_PATH%" spark serve --port 8080

pause
