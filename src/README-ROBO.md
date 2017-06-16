# Using Robo inside the container

## Step 1 - MySQL Server

First start an MySQL server with

```sh
console$ docker run -d \
    --name mysql-5.6 -p127.0.0.1:3306:3306 \
    -e MYSQL_ROOT_HOST=% \
    -e MYSQL_ROOT_PASSWORD=eraZor \
    mysql/mysql-server:5.6
```

## Step 2 - appserver.io

Start an appserver.io container with

```sh
$ docker run -d \
    -p127.0.0.1:80:80 \
    -p127.0.0.1:443:443 \
    -v /Users/wagnert/Workspace:/root/Workspace \
    --name appserver-1.1.4-magento 
    --link mysql-5.6:mysql \
    appserver/dist:1.1.4
$ docker cp target/magento2-ce-216.phar \
    appserver-1.1.4-magento:/opt/appserver/deploy/
$ docker cp target/magento2-ce-216.phar.dodeploy \
    appserver-1.1.4-magento:/opt/appserver/deploy/
```

## Step 3 - Deploy + Watch Sources

```sh
$ vendor/bin/robo deploy /root/Workspace/import-cli-magento/src app/code
```

```sh
$ vendor/bin/robo sync /root/Workspace/import-cli-magento/src app/code
```