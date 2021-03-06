VAGRANTFILE_API_VERSION = "2"

# IP Address for the host only network, change it to anything you like
# but please keep it within the IPv4 private network range
ip_address = "172.42.42.43"

# The project name is base for directories, hostname and alike
project_name = "larabooster"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |local|

  local.vm.box = "base"

  # /!\ By default it is "http://files.vagrantup.com/precise32.box" , but having it in local will make it faster
  # local.vm.box_url = "http://files.vagrantup.com/precise32.box"
  #
  local.vm.box_url = "~/Downloads/precise32.box"

    local.vm.provision :shell, :path => "install.sh"
    local.vm.synced_folder "./", "/vagrant", id: "vagrant-root" , :owner => "vagrant", :group => "www-data"
    local.vm.synced_folder "./app/storage", "/vagrant/app/storage", id: "vagrant-storage",
        :owner => "vagrant",
        :group => "www-data",
        :mount_options => ["dmode=775","fmode=664"]
    local.vm.synced_folder "./public", "/vagrant/public", id: "vagrant-public",
        :owner => "vagrant",
        :group => "www-data",
        :mount_options => ["dmode=775","fmode=664"]

    # Use hostonly network with a static IP Address and enable
    # hostmanager so we can have a custom domain for the server
    # by modifying the host machines hosts file
    local.hostmanager.enabled = true
    local.hostmanager.manage_host = true
    local.vm.define project_name do |node|
        node.vm.hostname = project_name + ".local"
        node.vm.network :private_network, ip: ip_address
        node.hostmanager.aliases = [ "www." + project_name + ".local" ]
    end
    local.vm.provision :hostmanager
end
