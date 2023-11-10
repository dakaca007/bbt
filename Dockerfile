# 使用官方的CentOS 7镜像作为基础
FROM centos:7

# 安装SSH服务器和生成主机密钥
RUN yum install -y openssh-server && \
    ssh-keygen -A

# 新增用户和密码
RUN useradd -ms /bin/bash xg  # 创建一个名为xg的新用户
RUN echo 'xg:password' | chpasswd  # 为xg用户设置密码为password

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

# 启动SSH服务
CMD ["/usr/sbin/sshd", "-D"]
