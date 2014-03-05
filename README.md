# Vagrant Laravel Booster

What's that?
------------
Checkout the online [demo](http://larabooster.bguez.io)

The purpose of this project is to show a tested laravel4 project using vagrant which install multiple database/cache system and use them whitin
a pretty angularJS/CoffeeScript webApp.
The only thing you can do is add a color into a container (MySQL, memcache, Redis, MongoDB, SQLite, FileStorage etc.)

## Getting started

Requirements
------------

To make good use of vagrant you need to download

1. [Vagrant](http://www.vagrantup.com/downloads.html)
    1.2 install Vagrant plugin hostmanager `vagrant plugin install vagrant-hostmanager`
2. [VirtualBox](https://www.virtualbox.org/wiki/Downloads)
3. Precise32 Box (You can do without, but it's better to have it in local)

Guidelines
----------

```
$ git clone http://github.com/beNjiox/larabooster
$ cd larabooster
$ vagrant up
```

run `http://larabooster.local` in your favorite browser