 FROM centos:7

# 安装必要的软件包
RUN yum -y update && \
    yum -y install epel-release && \
    yum -y install nginx php php-fpm php-mysqlnd mysql redis

# 配置Nginx
COPY nginx.conf /etc/nginx/nginx.conf
COPY localhost.conf /etc/nginx/conf.d/default.conf

# 配置PHP-FPM
COPY php-fpm.conf /etc/php-fpm.d/www.conf
COPY php.ini /etc/php.ini

# 启动服务
CMD service nginx start && service php-fpm start && service mysqld start && service redis start

# 暴露端口
EXPOSE 80 3306 6379
