# 使用官方的Ubuntu 20.04镜像作为基础
FROM ubuntu:20.04

# 更新包列表和安装基本工具
RUN apt-get update && apt-get install software-properties-common \
    && add-apt-repository ppa:ondrej/php \
    && apt-get update

# 安装Python 3和pip
RUN apt-get install -y python3 python3-pip

# 安装gcc编译器
RUN apt-get install -y gcc

# 安装PHP和Apache
RUN apt-get install -y apache2 libapache2-mod-php7.4 php7.4 php7.4-mysql

# 安装Flask和其他Python库
RUN pip3 install -i https://pypi.tuna.tsinghua.edu.cn/simple flask pymysql requests Werkzeug wtforms pexpect

# 设置工作目录
WORKDIR /app

# 将当前目录
EXPOSE 80

# 启动Apache
CMD ["apachectl", "-D", "FOREGROUND"]
