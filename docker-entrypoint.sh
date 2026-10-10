#!/bin/bash
set -e

echo "=========================================================="
echo "          Memulai Inisialisasi Desentra Container        "
echo "=========================================================="

# 1. Pastikan folder writable dan uploads memiliki direktori & permission yang tepat
mkdir -p /var/www/html/writable/cache \
         /var/www/html/writable/logs \
         /var/www/html/writable/session \
         /var/www/html/writable/uploads \
         /var/www/html/writable/debugbar \
         /var/www/html/public/uploads

chown -R www-data:www-data /var/www/html/writable /var/www/html/public/uploads
chmod -R 777 /var/www/html/writable /var/www/html/public/uploads

# 2. Pastikan file .env ada
if [ ! -f "/var/www/html/.env" ]; then
    if [ -f "/var/www/html/.env.example" ]; then
        echo "📋 Menyalin .env.example ke .env..."
        cp /var/www/html/.env.example /var/www/html/.env
    fi
fi

# 3. Jalankan composer install jika vendor belum ada
if [ ! -d "/var/www/html/vendor" ]; then
    echo "📦 Menginstall dependencies melalui Composer..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# 4. Generate encryption key jika belum terisi di .env
if [ -f "/var/www/html/.env" ]; then
    if grep -q "encryption.key = *$" /var/www/html/.env || grep -q "encryption.key = ''" /var/www/html/.env; then
        echo "🔑 Menghasilkan application encryption key..."
        php spark key:generate --force || true
    fi
fi

# 5. Tunggu database siap jika DB_HOST didefinisikan
DB_HOST="${DB_HOST:-db}"
DB_PORT="${DB_PORT:-3306}"

echo "⏳ Menunggu koneksi database ($DB_HOST:$DB_PORT) siap..."
MAX_TRIES=60
TRIES=0
while ! nc -z "$DB_HOST" "$DB_PORT"; do
    TRIES=$((TRIES + 1))
    if [ $TRIES -ge $MAX_TRIES ]; then
        echo "⚠️ Gagal terhubung ke database setelah $MAX_TRIES detik. Melewati proses migrasi..."
        break
    fi
    sleep 1
done

if [ $TRIES -lt $MAX_TRIES ]; then
    echo "✅ Database berhasil terhubung!"

    # Tambahan jeda singkat memastikan MySQL siap menerima query autentikasi
    sleep 2

    # 6. Jalankan migrasi database
    echo "🔄 Menjalankan migrasi database..."
    php spark migrate --all || true

    # 7. Jalankan database seed
    echo "🌱 Menjalankan seeder data awal (DesentraSeeder)..."
    php spark db:seed DesentraSeeder || true
fi

echo "=========================================================="
echo "          Desentra Siap Digunakan!                       "
echo "=========================================================="

exec "$@"
