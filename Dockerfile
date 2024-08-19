# 使用官方的 PHP + Apache 镜像
FROM php:7.4-apache


# 将当前目录中的所有文件复制到工作目录
COPY localhost/dp/ /var/www/html/



