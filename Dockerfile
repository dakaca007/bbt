# 使用官方的 PHP + Apache 镜像
FROM php:7.4-apache

# 安装 GD 扩展及其他依赖
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 设置 Apache 配置以允许 .htaccess 文件
RUN echo '<Directory /var/www/html>' > /etc/apache2/sites-available/000-default.conf && \
    echo '    AllowOverride All' >> /etc/apache2/sites-available/000-default.conf && \
    echo '</Directory>' >> /etc/apache2/sites-available/000-default.conf
# 将当前目录中的所有文件复制到工作目录
COPY localhost/ /var/www/html/

# 更改目录权限
RUN chmod -R 777 /var/www/html/e/
# 更改目录权限
RUN chmod -R 777 /var/www/html/lt/
