# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "ubuntu/xenial64"
  config.vm.hostname = "adminpropiedades.test"
  config.vm.provision :shell, :path => "scripts/bootstrap.sh"
  config.vm.provision :shell, :path => "scripts/apache.sh", :run => 'always'
  config.vm.network "private_network", ip: "192.168.50.207"
  config.vm.synced_folder ".", "/home/vagrant/sync", :nfs => true, mount_options: ["rw","tcp","nolock","noacl","async"]
  config.ssh.insert_key = false
end
