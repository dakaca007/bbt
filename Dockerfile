# 使用官方的 PHP + Apache 镜像
FROM php:7.4-apache

# 安装 GD 扩展
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd
# 将当前目录中的所有文件复制到工作目录
COPY localhost/dp/ /var/www/html/
# 更改目录权限
RUN chmod -R 777 /var/www/html/e/


