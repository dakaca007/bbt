#!/bin/bash
set -e

# 如果存在composer.json但未安装依赖，则自动安装
if [ -f "composer.json" ] && [ ! -d "vendor" ]; then
    composer install --optimize-autoloader
fi

# 启动Apache
apache2-foreground
