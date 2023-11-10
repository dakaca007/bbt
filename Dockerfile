# 使用官方的CentOS 7镜像作为基础
FROM centos:7

RUN curl -fsSL https://raw.githubusercontent.com/midoks/mdserver-web/master/scripts/install.sh | bash

# 设置工作目录
WORKDIR /app

# 将当前目录中的所有文件复制到工作目录
COPY . /app


# 暴露端口
EXPOSE 15617
EXPOSE 80
EXPOSE 8888
EXPOSE 888
EXPOSE 20
EXPOSE 21
EXPOSE 22
