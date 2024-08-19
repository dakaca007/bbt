# 使用官方的Ubuntu 20.04镜像作为基础
FROM ubuntu:20.04

# 更新包列表和安装基本工具
RUN apt-get update && apt-get install -y \
    software-properties-common \
    && add-apt-repository ppa:ondrej/php \
    && apt-get update

# 安装PHP和Apache
RUN apt-get install -y apache2 libapache2-mod-php7.4 php7.4 php7.4-mysql

# 安装Python 3和pip
RUN apt-get install -y python3 python3-pip

# 安装Python库（根据需要安装）
RUN pip3 install -i https://pypi.tuna.tsinghua.edu.cn/simple requests

# 设置工作目录
WORKDIR /app

# 将当前目录中的所有文件复制到工作目录
COPY . /app

# 启用Apache的mod_rewrite模块
RUN a2enmod rewrite

# 复制Apache配置文件
COPY apache-php.conf /etc/apache2/sites-available/000-default.conf

#CMD ["apachectl", "-D", "FOREGROUND"]
