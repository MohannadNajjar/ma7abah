FROM php:8.3-apache

# إضافة PostgreSQL لـ PHP + تفعيل ملف .htaccess
RUN apt-get update \
 && apt-get install -y --no-install-recommends libpq-dev \
 && docker-php-ext-install pdo_pgsql \
 && rm -rf /var/lib/apt/lists/* \
 && a2enmod rewrite \
 && sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# رفع حد حجم الصورة
RUN printf 'upload_max_filesize=6M\npost_max_size=8M\n' > /usr/local/etc/php/conf.d/uploads.ini

COPY . /var/www/html/
EXPOSE 80
