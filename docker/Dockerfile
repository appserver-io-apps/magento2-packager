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

# activate the always_populate_raw_post_data in PHP php.ini
RUN sed -i "s/;always_populate_raw_post_data = On/always_populate_raw_post_data = -1/g" etc/php-fpm-fcgi.ini

################################################################################

# replace the default user/group for the PHP-FPM configuration
RUN sed -i "s/user = www-data/user = root/g" etc/php-fpm.conf \
   && sed -i "s/group = www-data/group = root/g" etc/php-fpm.conf

################################################################################

# copy all files into the build context
COPY docker/ /

################################################################################

# define default command
ENTRYPOINT ["/usr/bin/supervisord"]