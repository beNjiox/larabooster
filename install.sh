#!/usr/bin/env bash
sudo apt-get update

echo "[ ------ Setup MySQL ------ ]"
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'

echo "[ ------ Installing essentials ------ ]"
# Install base items

sudo apt-get install -y vim tmux curl wget build-essential software-properties-common python-software-properties
sudo add-apt-repository -y ppa:ondrej/php5
sudo apt-get update
sudo apt-get install -y git-core php5 apache2 libapache2-mod-php5 php5-mysql php5-curl php5-gd php5-mcrypt php5-xdebug php5-readline mysql-server emacs

echo "[ ------ Update Git ------ ]"
sudo add-apt-repository ppa:git-core/ppa
sudo apt-get update
sudo apt-get install git

echo "[ ------ Install Memcache ------ ]"
sudo apt-get install -y memcached php5-memcache php5-memcached
sudo service memcached start

echo "[ ------ Install Redis ------ ]"
sudo apt-get install -y redis-server
sudo mkdir -p /etc/redis/conf.d
sudo service redis-server restart

echo "[ ------ Install MySQL ------ ]"
# Of course if used in a production/critical mode, you might want to change this
echo "create database larabooster" | mysql -uroot -proot

echo "[ ------ Install MongoDB ------ ]"
# Get key and add to sources
sudo apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 7F0CEB10
echo 'deb http://downloads-distro.mongodb.org/repo/ubuntu-upstart dist 10gen' | sudo tee /etc/apt/sources.list.d/mongodb.list
# Update
sudo apt-get update
# Install MongoDB
sudo apt-get -y install mongodb-10gen

echo "[ ------ Setup Server ------ ]"
cat << EOF | sudo tee -a /etc/php5/mods-available/xdebug.ini
xdebug.scream=1
xdebug.cli_color=1
xdebug.show_local_vars=1
EOF

echo "[ ------ Setup Apache ------ ]"
sudo a2enmod rewrite
sed -i 's/\/var\/www\/html/\/var\/www/' /etc/apache2/sites-available/000-default.conf
sudo service apache2 reload

echo "[ ------ Setup PHP ------ ]"
sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php5/apache2/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php5/apache2/php.ini
sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

sudo service apache2 restart

echo "[ ------ Start Composer ------ ]"
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
cd /vagrant && sudo composer install

echo "[ ------ Setup App ------ ]"
cd /vagrant && php artisan migrate

echo "[ ------ Linking the app to /var/www ------ ]"
sudo rm -rf /var/www
sudo ln -s /vagrant/public /var/www

echo "[ ------ Setup ZSH ------ ]"
apt-get install zsh
sudo su - vagrant -c 'curl -L http://bit.ly/bguezsh > ~/bguezsh'
sudo su - vagrant -c 'sh ~/bguezsh'

