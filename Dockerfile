FROM php:8.2-apache

# Bật mod_rewrite cho Apache
RUN a2enmod rewrite

# Cài extension PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Cài thư viện cần thiết cho GD và các extension runtime của PHPSpreadsheet
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libfreetype-dev \
        libjpeg-dev \
        libpng-dev \
        libwebp-dev \
        libzip-dev \
        libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd mbstring zip \
    && rm -rf /var/lib/apt/lists/*

# Cài composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Cấu hình Apache và cho phép truy cập thư mục public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf && \
    sed -i 's|AllowOverride None|AllowOverride All|g' /etc/apache2/apache2.conf && \
    printf '\n<Directory /var/www/html/public>\n    Options FollowSymLinks\n    AllowOverride All\n    Require all granted\n</Directory>\n' >> /etc/apache2/apache2.conf

# Đặt thư mục làm việc
WORKDIR /var/www/html

# Copy source code vào image (volumes sẽ override khi dev)
COPY . .

# Cài vendor nếu chưa có
RUN if [ ! -d vendor ]; then composer install --no-dev --optimize-autoloader; fi

# Gán quyền
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
