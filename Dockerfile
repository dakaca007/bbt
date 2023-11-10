# 使用官方的CentOS 7镜像作为基础
FROM centos:7

# 安装SSH服务器和生成主机密钥
RUN yum install -y openssh-server && \
    ssh-keygen -A

# 新增用户和密码
RUN useradd -ms /bin/bash xg  # 创建一个名为xg的新用户
RUN echo 'xg:password' | chpasswd  # 为xg用户设置密码为password

# 安装简单的web服务器
RUN yum install -y httpd
ADD index.html /var/www/html/

# 设置工作目录
WORKDIR /app

# 暴露端口
EXPOSE 22
EXPOSE 80

# 启动SSH服务和Web服务器
CMD ["/usr/sbin/sshd", "-D"] && ["httpd", "-D", "FOREGROUND"]
