# 使用官方的CentOS 7镜像作为基础
FROM centos:7
RUN hostname yourhostname
RUN service network restart
# 安装宝塔面板
RUN yum install -y wget && wget -O install.sh https://download.bt.cn/install/install_6.0.sh && sh install.sh ed8484bec

# 设置工作目录
WORKDIR /app

# 将当前目录中的所有文件复制到工作目录
COPY . /app


# 暴露端口
EXPOSE 80
EXPOSE 8888
EXPOSE 888
EXPOSE 20
EXPOSE 21
EXPOSE 22
