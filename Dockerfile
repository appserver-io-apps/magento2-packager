################################################################################
# Dockerfile for appserver.io Magento 2 application
################################################################################

# base image
FROM wagner83104/dist:1.1.1-alpha10

# define versions
ENV MAGENTO2_VERSION 2.0.1

################################################################################

# author
MAINTAINER Tim Wagner <tw@appserver.io>

################################################################################

# install a mysql server instance
RUN apt-get update \

   && DEBIAN_FRONTEND=noninteractive apt-get install -y mysql-server

################################################################################

# create the Magento 2 installation directory
RUN mkdir /opt/appserver/webapps \

    # create the installation directory
    && cd /opt/appserver/webapps \

    # download the Magento 2 sources from Github
    && wget https://github.com/magento/magento2/archive/${MAGENTO2_VERSION}.tar.gz \

    # extract the Magento 2 sources 
    && tar xvfz ${MAGENTO2_VERSION}.tar.gz \
    
    && cd magento2-${MAGENTO2_VERSION}

    # finally install the Magento 2 sources
    # && composer install --prefer-dist --no-dev --no-interaction --optimize-autoloader

################################################################################

# override the appserver.io default supervisor configuration
RUN rm /etc/supervisor/conf.d/supervisord.conf
COPY docker/etc/supervisor/conf.d/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

################################################################################

# copy appserver.io specfic configuration files
COPY src/ /opt/appserver/webapps/magento/

################################################################################

WORKDIR /opt/appserver/webapps/magento

################################################################################

VOLUME /var/lib/mysql

################################################################################

# Run Magento 2 installation here

################################################################################

# define default command
ENTRYPOINT ["/usr/bin/supervisord"]