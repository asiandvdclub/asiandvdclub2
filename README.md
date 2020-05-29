# Asian DVD Club v2
A new adc v2 framework 
## Getting Started
Framework works well on Ubunut Server with apache2, mysql and memchaced.
### Prerequisites
* Apache2 with PHP 7.3
* MySQL
* Memchaced
### Installing
1) Update the Ubunut server to latest version:
```
sudo apt update
sudo apt upgrade -y
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```
2) Installing apache2, php 7.3 and its modules, 
```
sudo apt install apache2 libapache2-mod-php7.3 php7.3 php7.3-common php7.3-cli php7.3-mysql php7.3-gd php-pear php-memcached
sudo apt install php-dev autoconf automake
sudo apt install -y pkg-config
```
3) Getting memchaced
```
sudo apt install memcached
sudo apt install libmemcached-dev libmemcached11
sudo pecl install memcached
sudo apt-get install zlib1g-dev
```
3) Installing MySQL with Email server
```
sudo apt install mysql-server
sudo apt install postfix
```
4) Enable memchaced module in php
```
sudo nano /etc/php/7.3/apache2/php.ini
add "extension=memcached.so" at the end of the file
```
5) Enable Module Rewrite on apache2
```
sudo a2enmod rewrite
sudo systemctl restart apache2.service
```
