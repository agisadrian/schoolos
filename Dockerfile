FROM richarvey/nginx-php-fpm:3.1.6

COPY . .

# --- Image config ---
# Vendor/ sudah ikut ke-commit di repo ini, jadi composer install
# tidak perlu dijalankan lagi saat container start (lebih cepat & stabil).
ENV SKIP_COMPOSER=1
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1
ENV COMPOSER_ALLOW_SUPERUSER=1

# --- Laravel config default (bisa dioverride dari Render dashboard) ---
ENV APP_ENV=production
ENV APP_DEBUG=false

CMD ["/start.sh"]
