# 使用官方的Ubuntu 20.04镜像作为基础
FROM ubuntu:20.04

# 更新包列表和安装基本工具
RUN apt-get update && apt-get install -y \
    software-properties-common \
    && add-apt-repository ppa:ondrej/php \
    && apt-get update

# 安装Python 3和pip
RUN apt-get install -y python3 python3-pip

# 安装gcc编译器
RUN apt-get install -y gcc

# 安装PHP解释器
RUN apt-get install -y php7.4 php7.4-cli php7.4-mysql

# 设置工作目录
WORKDIR /app

# 将当前目录中的所有文件复制到工作目录
COPY . /app

# 安装Python库
RUN pip3 install -i https://pypi.tuna.tsinghua.edu.cn/simple flask pymysql requests Werkzeug wtforms pexpect

# 暴露端口
EXPOSE 80

# 启动脚本
CMD ["bash", "start.sh"]
