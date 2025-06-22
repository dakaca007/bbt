#!/bin/bash
set -e

# 检查并安装 Composer 依赖
if [ -f "composer.json" ] && [ ! -d "vendor" ]; then
    echo "Installing Composer dependencies..."
    composer install --optimize-autoloader --no-interaction --no-progress
fi

# 设置正确的文件权限
echo "Setting file permissions..."
chown -R www-data:www-data /var/www/html
find /var/www/html -type d -exec chmod 755 {} \;
find /var/www/html -type f -exec chmod 644 {} \;

# 启动 Apache
echo "Starting Apache server..."
exec apache2-foreground
