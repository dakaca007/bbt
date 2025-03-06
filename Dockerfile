# 使用官方的 PHP + Apache 镜像
FROM php:7.4-apache

# 安装 GD 扩展及其他依赖（修正多行RUN格式）
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    git \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite headers \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 下载并安装 Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 将当前目录中的所有文件复制到工作目录
COPY localhost/ /var/www/html/

# 在工作目录中安装 Ratchet
WORKDIR /var/www/html
RUN composer require cboden/ratchet

# 设置 Apache 配置（修复原有错误并添加 CORS 头）
RUN { \
    echo '<VirtualHost *:80>'; \
    echo '  ServerAdmin webmaster@localhost'; \
    echo '  DocumentRoot /var/www/html'; \
    echo '  Header always set Access-Control-Allow-Origin "*"'; \
    echo '  Header always set Access-Control-Allow-Methods "GET, POST, OPTIONS"'; \
    echo '  Header always set Access-Control-Allow-Headers "Content-Type"'; \
    echo '  <Directory /var/www/html>'; \
    echo '    AllowOverride All'; \
    echo '    Require all granted'; \
    echo '  </Directory>'; \
    echo '  ErrorLog ${APACHE_LOG_DIR}/error.log'; \
    echo '  CustomLog ${APACHE_LOG_DIR}/access.log combined'; \
    echo '</VirtualHost>'; \
} > /etc/apache2/sites-available/000-default.conf

# 更改目录权限
RUN chmod -R 777 /var/www/html/e/

# 启动 Apache
CMD ["apache2-foreground"]
