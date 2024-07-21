FROM nginx:latest AS base

WORKDIR /var/project

RUN nproc
RUN lscpu
RUN ulimit -n

# RUN nginx -V
# RUN nginx -t

# RUN nginx -s reload
# RUN service nginx restart

############################################################################################
FROM base as local

ADD ./project-nginx.conf /etc/nginx/conf.d/default.conf

############################################################################################
FROM base as develop

ADD ./project-nginx.conf /etc/nginx/conf.d/default.conf

############################################################################################
FROM base as production

# Install packages
RUN apt-get install openssl

ADD ./project-nginx-production.conf /etc/nginx/conf.d/default.conf
