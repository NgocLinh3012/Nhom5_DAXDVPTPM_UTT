FROM php:8.2-apache

# Bật mod_rewrite cho Apache
RUN a2enmod rewrite

# Cài extension PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Cài composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Cấu hình Apache: DocumentRoot = /var/www/html
# Cho phép .htaccess
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html|g' /etc/apache2/sites-available/000-default.conf && \
    sed -i 's|<Directory /var/www/>|<Directory /var/www/html/>|g' /etc/apache2/apache2.conf && \
    sed -i 's|AllowOverride None|AllowOverride All|g' /etc/apache2/apache2.conf

# Đặt thư mục làm việc
WORKDIR /var/www/html/thitracnghiem

# Copy source code vào image (volumes sẽ override khi dev)
COPY . .

# Cài vendor nếu chưa có
RUN if [ ! -d vendor ]; then composer install --no-dev --optimize-autoloader; fi

# Gán quyền
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
