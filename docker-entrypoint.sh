#!/bin/bash
set -e  # 任何命令失败时退出脚本

# 根据环境变量区分开发/生产行为
if [ "$APP_ENV" = "dev" ]; then
    echo "运行在开发模式"
    # 开发环境：确保依赖已安装
    if [ ! -d "vendor" ]; then
        composer install --optimize-autoloader
    fi
    # 开发环境：开放写权限（按需调整）
    chmod -R 775 /var/www/html/e/ 2>/dev/null || true
else
    echo "运行在生产模式"
    # 生产环境：确保缓存和日志目录可写
    chmod -R 775 /var/www/html/var/cache/ 2>/dev/null || true
    chmod -R 775 /var/www/html/var/log/ 2>/dev/null || true
fi

# 启动Apache（前台运行）
apache2-foreground &
APACHE_PID=$!

# 开发环境：监控文件变化自动更新
if [ "$APP_ENV" = "dev" ]; then
    while kill -0 $APACHE_PID 2>/dev/null; do
        echo "监控文件变化中..."
        inotifywait -r -e modify,create,delete /var/www/html/
        # 检测到变化时重新安装依赖（如composer.json变更）
        if [ -f "composer.json" ] && [ "composer.json" -nt "vendor" ]; then
            composer install --optimize-autoloader
        fi
        # 清理缓存
        rm -rf /var/www/html/var/cache/* 2>/dev/null || true
    done
else
    # 生产环境：仅等待Apache退出
    wait $APACHE_PID
fi
