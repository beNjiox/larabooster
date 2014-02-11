#!/usr/bin/env bash

# install.sh highly inspired by great laracasts lessons
# www.laracasts.com

echo "[ ------ Laravel + Redis + Memcache + MySQL  ------ ]"
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

echo "[ ------ Install Redis ------ ]"
sudo wget http://download.redis.io/redis-stable.tar.gz
sudo tar xvzf redis-stable.tar.gz
cd redis-stable && make && cd src/
sudo cp redis-server /usr/local/bin/
sudo cp redis-cli /usr/local/bin/

echo "[ ------ Install MySQL ------ ]"
# Of course if used in a production/critical mode, you might want to change this
echo "create database larabooster" | mysql -uroot -proot


echo "[ ------ Setup Server ------ ]"

cat << EOF | sudo tee -a /etc/php5/mods-available/xdebug.ini
xdebug.scream=1
xdebug.cli_color=1
xdebug.show_local_vars=1
EOF

echo "[ ------ Setup Apache ------ ]"
sudo a2enmod rewrite
curl https://gist.github.com/fideloper/2710970/raw/vhost.sh > vhost
sudo chmod guo+x vhost
sudo mv vhost /usr/local/bin

echo "[ ------ Setup PHP ------ ]"
sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php5/apache2/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php5/apache2/php.ini
sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

sudo service apache2 restart

echo "[ ------ Setup Git ------ ]"
curl https://gist.github.com/fideloper/3751524/raw/.gitconfig > /home/vagrant/.gitconfig
sudo chown vagrant:vagrant /home/vagrant/.gitconfig

echo "[ ------ Start Composer ------ ]"
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
cd /vagrant && sudo composer install

echo "[ ------ Setup App ------ ]"
cd /vagrant && php artisan migrate

echo "[ ------ Linking the app to /var/www ------ ]"
sudo rm -rf /var/www
sudo ln -s /vagrant/public /var/www

echo "[ ------ Setup services ------ ]"
sudo service memcached start&
redis-server&

echo "Welcome !"

echo "browse larabooster.local"