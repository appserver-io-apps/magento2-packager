################################################################################
# Dockerfile for appserver.io Magento 2 application
################################################################################

# base image
FROM appserver/dist

################################################################################

# author
MAINTAINER Tim Wagner <tw@appserver.io>

################################################################################

# install a mysql server instance
RUN apt-key adv --keyserver pgp.mit.edu --recv-keys 5072E1F5 \
   && echo "deb http://repo.mysql.com/apt/debian/ jessie mysql-5.6" >> /etc/apt/sources.list.d/mysql.list \
   && apt-get update \
   && DEBIAN_FRONTEND=noninteractive apt-get install -y mysql-server

################################################################################

# copy all files into the build context
COPY docker/ /

################################################################################

# define default command
ENTRYPOINT ["/usr/bin/supervisord"]