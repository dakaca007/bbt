# 使用官方PHP+Apache镜像（指定版本）
FROM php:7.4-apache

# 替换为阿里云镜像源（中国用户加速）
RUN sed -i 's/deb.debian.org/mirrors.aliyun.com/g' /etc/apt/sources.list \
    && sed -i 's/security.debian.org/mirrors.aliyun.com/g' /etc/apt/sources.list

# 安装系统依赖和PHP扩展（合并命令减少镜像层）
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    git \
    unzip \
    # 开发工具（仅开发环境需要，生产构建时可移除）
    inotify-tools \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql \
    && a2enmod rewrite \
    # 清理缓存减小镜像体积
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 安装Composer（全局可用）
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# 设置工作目录
WORKDIR /var/www/html

# 先复制composer文件安装依赖（利用Docker层缓存）
COPY localhost/composer.* ./
RUN composer install --no-dev --optimize-autoloader

# 复制应用代码（排除开发文件如node_modules）
COPY localhost/ ./

# 自定义Apache配置（保留默认日志设置）
COPY apache.conf /etc/apache2/sites-available/000-default.conf
RUN a2ensite 000-default.conf

# 设置权限（生产环境推荐）
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;

# 复制入口点脚本并赋予执行权限
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# 暴露端口
EXPOSE 80

# 入口点
ENTRYPOINT ["docker-entrypoint.sh"]
