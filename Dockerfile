# 使用官方的 PHP + Apache 镜像
FROM php:7.4-apache

# 安装 Python 和 pip
RUN apt-get update && apt-get install -y \
    python3 \
    python3-pip \
    && rm -rf /var/lib/apt/lists/*

# 将当前目录中的所有文件复制到工作目录
COPY public/ /var/www/html/
COPY scripts/ /usr/local/bin/

# 确保 Python 脚本可执行
RUN chmod +x /usr/local/bin/helper.py
