#!/bin/bash

# 启动PHP-FPM
php-fpm8.1 &

# 启动Supervisor（管理其他服务）
/usr/bin/supervisord -c /etc/supervisor/supervisord.conf

# 保持容器运行
tail -f /dev/null