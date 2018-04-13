#!/bin/bash

# Variables
php_version="7.2"
mysql_version="5.5"
mariadb_version="10.2"

db_password='rootpass'

php_config_file="/etc/php/${php_version}/apache2/php.ini"
mysql_config_file="/etc/mysql/my.cnf"


# Main function called at the very bottom of the file
main() {
	updateConfig
	addLocales
	apacheConfig
	phpConfig
	composerConfig
	nodejsConfig
	mysqlConfig
	restartServices
    laravelInstall
	cleanUp
}

updateConfig() {
	###### Download and Install the latest updates for the OS
	printf "\n\n\n\n[ #### Update all the dependencies #### ]\n\n"
    sudo apt-get update && sudo apt-get upgrade
}

addLocales() {
	###### Download and Install locales
	printf "\n\n\n\n[ #### Download and Install locales #### ]\n\n"
    # Check which locales are supported
    printf "\nSupported locales\n"
    locale -a
    # Add locales
    #sudo locale-gen sl_SI.UTF-8
    # Update command
    #sudo update-locale
    # Check which locales are supported
    printf "\nSupported locales\n"
    locale -a
}

apacheConfig() {
    ###### Apache
    printf "\n\n\n\n[ #### Install Apache #### ]\n\n"
    sudo apt-get install apache2 -y
    printf "\n"
    # Later PHP install fails if you don't remove Apache warning
    # To turn off warning add line to the end of a file "ServerName localhost"


    ln -fs /home/vagrant/sync /var/www/laraveltraining

    # disable default site conf
    sudo a2dissite 000-default.conf

    # enable laraveltraining.conf
    ln -fs /var/www/laraveltraining/scripts/laraveltraining.conf /etc/apache2/sites-available/
    sudo a2ensite laraveltraining.conf

    # change apache user and group to vagrant
    sudo sed -ie 's/User www-data/User vagrant/g' /etc/apache2/apache2.conf
    sudo sed -ie 's/Group www-data/User vagrant/g' /etc/apache2/apache2.conf

    sudo systemctl restart apache2
    sudo apache2ctl configtest
    printf "\n"
    
    # Enable Apache mod_rewrite or prompt that the module is already in effect
    printf "\n### Enable module rewrite ###\n"
    sudo a2enmod rewrite
    sudo service apache2 restart
    # Replace the third occurrence of string AllowOverride None with AllowOverride All
    
    printf "\n"
    apache2 -v
}

phpConfig() {
    ###### PHP
    printf "\n\n\n\n[ #### Install PHP with extensions #### ]\n\n"
    sudo apt-add-repository ppa:ondrej/php -y
    sudo apt-get update
    sudo apt-get install -y php7.2

    # add php 7.2 modules
    sudo apt-get install -y php7.2-common php-pear php7.2-gd php7.2-mysql php7.2-imap php7.2-cli php7.2-cgi php7.2-curl php7.2-intl php7.2-pspell php7.2-recode php7.2-sqlite3 php7.2-tidy php7.2-xmlrpc php7.2-xsl php7.2-zip php7.2-mbstring php7.2-soap php7.2-xml
    
    printf "\n[ #### Installed PHP modules #### ]\n"
    php -m

    printf "\n"
    php -v
}

composerConfig() {
    ###### Composer
    printf "\n\n\n\n[ #### Install Composer #### ]\n\n"
    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer

    printf "\n"
    composer --version
}

nodejsConfig() {
    ###### Node.js & npm
    printf "\n\n\n\n[ #### Install Node.js & npm #### ]\n\n"
    curl -sL https://deb.nodesource.com/setup_8.x | sudo -E bash -
    sudo apt-get install -y nodejs

    printf "\n"
    node -v
    printf "\n"
    npm -v
}

mysqlConfig() {
    ###### MySQL
    # No new empty lines allowed in the lower block
    printf "\n\n\n\n[ #### Install MySQL #### ]\n\n"
    sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
    sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'
    sudo apt-get -y install mysql-server
    printf "\n"

    # Update mysql configs file.
    printf "\n\n\n\n[ #### Updating mysql configs in ${mysql_config_file}.#### ]\n\n"

    sudo sed -i "s/.*bind-address.*/bind-address = 0.0.0.0/" ${mysql_config_file}
    printf "\nUpdated mysql bind address in ${mysql_config_file} to 0.0.0.0 to allow external connections\n"

    sudo sed -i "/.*skip-external-locking.*/s/^/#/g" ${mysql_config_file}
    printf "\nUpdated mysql skip-external-locking in ${mysql_config_file} to #skip-external-locking. If you run multiple servers that use the same database directory (not recommended), each server must have external locking enabled\n"

    # Assign mysql root user access on %
    mysql -uroot -p'root' -e "grant all privileges on *.* to 'root'@'%' identified by 'root'";
    mysql -uroot -p'root' -e "grant all privileges on *.* to 'root'@'localhost' identified by 'root'";
    mysql -uroot -p'root' -e "create database laraveltraining"
    
    # sudo mysql -u root -p$db_password --execute "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY '$db_password' with GRANT OPTION; FLUSH PRIVILEGES;"
    printf "Assigned mysql user 'root' access on all hosts."
    printf "Database: laraveltraining created."

    # Restart mysql service
    sudo service mysql restart

    printf "\n"
    mysql --version
}

restartServices() {
    ###### Restart services
    printf "\n\n\n\n[ #### Restart services #### ]\n\n"
    sudo service apache2 restart
    sudo service mysql restart
}

laravelInstall() {
    ###### run install commands
    printf "\n\n\n\n[ #### Run Composer Install, set .env, key and run migrations #### ]\n\n"
    
    cd /home/vagrant/sync
    @ra
    composer install
    composer dumpauto
    cp .env.example .env

    php artisan key:generate
}

cleanUp() {
    ###### Disk space optimization
    # Clear out the local repository of retrieved package files (remove everything but the lock file
    # from /var/cache/apt/archives/ and /var/cache/apt/archives/partial/)
    sudo apt-get clean
    # Zero out drive (write zeroes to all empty space on the volume, which will allow better
    # compression of the physical file containing the virtual disk)
    sudo dd if=/dev/zero of=/EMPTY bs=1M
    sudo rm -f /EMPTY
    # Clear Bash History
    cat /dev/null > ~/.bash_history && history -c && exit
}

main
