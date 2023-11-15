 FROM centos:7

# 安装必要的软件包
RUN yum -y update && \
    yum -y install epel-release && \
    yum -y install nginx php php-fpm php-mysqlnd mysql redis
# 安装Python 3和pip
RUN yum install -y epel-release && yum install -y python3 && yum install -y python3-pip

# 安装gcc编译器
RUN yum install -y gcc
RUN pip3 install -i https://pypi.tuna.tsinghua.edu.cn/simple flask
RUN pip3 install -i https://pypi.tuna.tsinghua.edu.cn/simple requests
RUN pip3 install -i https://pypi.tuna.tsinghua.edu.cn/simple Werkzeug

RUN pip3 install -i https://pypi.tuna.tsinghua.edu.cn/simple wtforms
# 设置工作目录
WORKDIR /www
# 配置Nginx
COPY nginx.conf /etc/nginx/nginx.conf
COPY localhost.conf /etc/nginx/conf.d/localhost.conf

# 配置PHP-FPM
COPY php-fpm.conf /etc/php-fpm.d/www.conf
COPY php.ini /etc/php.ini


COPY . /www
RUN groupadd -g 1000 www-data && \
    useradd -u 1000 -g www-data -m www-data
# 启动服务
#CMD  ["php-fpm"], ["mysqld"],["nginx", "-g", "daemon off;"],["python3 app.py"]
CMD ["python3 app.py"]
# 暴露端口
EXPOSE 80
