FROM ubuntu:22.04

# 使用阿里云镜像源
RUN sed -i 's/archive.ubuntu.com/mirrors.aliyun.com/g' /etc/apt/sources.list && \
    sed -i 's/security.ubuntu.com/mirrors.aliyun.com/g' /etc/apt/sources.list

# 安装基础依赖
RUN apt update && DEBIAN_FRONTEND=noninteractive apt install -y \
    bash \
    nginx \
    php8.1-fpm \
    php8.1-mysql \
    php8.1-curl \
    php8.1-dom \
    php8.1-mbstring \
    php8.1-zip \
    php8.1-gd \
    php8.1-bcmath \
    php8.1-intl \
    php8.1-xml \
    php8.1-sqlite3 \
    php8.1-pgsql \
    # 开发工具
    composer \
    git \
    unzip \
    nodejs \
    npm \
    # 缓存和队列依赖
    redis-server \
    supervisor \
    && rm -rf /var/lib/apt/lists/*

# 配置Nginx目录权限
RUN mkdir -p /var/log/nginx /var/lib/nginx /var/www/html/php \
    && chown -R www-data:www-data /var/log/nginx /var/lib/nginx /var/www/html \
    && chmod 755 /var/log/nginx /var/lib/nginx
# 设置Composer阿里云镜像（加速下载）
RUN composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
# 安装常用NPM包（按需添加）
RUN npm install -g yarn pnpm
# 配置PHP框架环境
RUN sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/" /etc/php/8.1/fpm/php.ini && \
    echo "env[PATH] = /usr/local/bin:/usr/bin:/bin" >> /etc/php/8.1/fpm/pool.d/www.conf
WORKDIR /var/www/html/php

# PHP运行环境配置
RUN mkdir -p /run/php && chown www-data:www-data /run/php
RUN echo "<?php phpinfo(); ?>" > /var/www/html/php/info.php \
    && echo "<?php echo 'Hello from PHP test!'; ?>" > /var/www/html/php/test.php \
    && chown -R www-data:www-data /var/www/html/php \
    && chmod 755 /var/www/html/php/*.php
COPY ./localhost /var/www/html/php

# 配置Nginx
COPY nginx.conf /etc/nginx/sites-available/default

# 配置启动脚本
COPY start.sh /start.sh
RUN chmod +x /start.sh

# 暴露端口
EXPOSE 80

# 启动服务
CMD ["/start.sh"]
