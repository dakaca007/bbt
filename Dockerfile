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
    # Python环境
    python3-pip python3-venv \
    # Go语言环境
    golang-go \
    # Node.js环境（包含npm）
    nodejs \
    composer \
    git \
    unzip \
    nodejs \
    npm \
    # 缓存和队列依赖
    redis-server \
    supervisor \
    && rm -rf /var/lib/apt/lists/*
# 配置全局目录结构
RUN mkdir -p \
    /var/log/nginx \
    /var/lib/nginx \
    /var/www/html/php \
    /var/www/html/python \
    /var/www/html/go \
    /var/www/html/node \
    /run/php \
    /run/gunicorn \
    /run/supervisor
# 配置Nginx目录权限
RUN mkdir -p /var/log/nginx /var/lib/nginx /var/www/html/php \
    && chown -R www-data:www-data /var/log/nginx /var/lib/nginx /var/www/html \
    && chmod 755 /var/log/nginx /var/lib/nginx
# 配置目录权限
RUN chown -R www-data:www-data \
    /var/log/nginx \
    /var/lib/nginx \
    /var/www/html \
    /run/php \
    /run/gunicorn
# 设置Composer阿里云镜像（加速下载）
RUN composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
# 安装常用NPM包（按需添加）
RUN npm install -g yarn pnpm
# 配置PHP框架环境
RUN sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/" /etc/php/8.1/fpm/php.ini && \
    echo "env[PATH] = /usr/local/bin:/usr/bin:/bin" >> /etc/php/8.1/fpm/pool.d/www.conf

WORKDIR /var/www/html

# 配置PHP环境
RUN echo "<?php phpinfo(); ?>" > php/info.php && \
    composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
COPY ./localhost /var/www/html/php
# 配置Python环境
RUN pip3 install gunicorn flask --no-cache-dir -i https://pypi.tuna.tsinghua.edu.cn/simple
COPY ./app.py python/
RUN chown -R www-data:www-data python
# 配置Go环境
COPY ./go-app.go go/
RUN go mod init mygoapp && go build -o /usr/bin/goapp go/*.go && \
    chown -R www-data:www-data go
# 配置Node.js环境
COPY ./package.json ./server.js node/
RUN npm install --prefix node --registry=https://registry.npmmirror.com && \
    chown -R www-data:www-data node
# 配置Nginx
COPY nginx.conf /etc/nginx/sites-available/default
# 配置Supervisor（管理多进程）
COPY supervisord.conf /etc/supervisor/supervisord.conf
# 配置启动脚本
COPY start.sh /start.sh
RUN chmod +x /start.sh

# 暴露端口
EXPOSE 80

# 启动服务
CMD ["/start.sh"]
