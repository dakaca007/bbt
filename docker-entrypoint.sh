#!/bin/bash

# 启动Apache后台服务
apache2-foreground &

# 如果存在vendor目录，则说明已经安装过依赖
if [ ! -d "vendor" ]; then
    composer install
fi

# 设置目录权限
chmod -R 777 /var/www/html/e/ 2>/dev/null || true

# 监控文件变化的循环
while true; do
    # 使用inotifywait监控文件变化
    inotifywait -r -e modify,create,delete /var/www/html/
    
    # 当检测到变化时，执行以下操作
    echo "检测到文件变化，自动更新..."
    
    # 如果有新的composer依赖，可以自动安装
    if [ -f "composer.json" ] && [ "composer.json" -nt "vendor" ]; then
        composer install
    fi
    
    # 清除任何可能存在的缓存
    rm -rf /var/www/html/var/cache/* 2>/dev/null || true
    
    # 确保Apache已运行
    if ! pgrep "apache2" > /dev/null; then
        apache2-foreground &
    fi
done
