# These actions will be run at provisioning time
# Most of these commands are ephemeral, so you will probably have to rerun them if you reboot the VM

# Install Apache and PHP
sudo apt-get update
sudo apt-get install apache2 -y
sudo apt-get install php libapache2-mod-php php-mcrypt php-mysql -y
sudo systemctl restart apache2

# Delete default web site and download a new one
sudo rm /var/www/html/index.html
sudo apt-get install wget -you
sudo wget https://raw.githubusercontent.com/erjosito/IaC-Test/master/index.php -P /var/www/html/
sudo wget https://raw.githubusercontent.com/erjosito/IaC-Test/master/styles.css -P /var/www/html/
sudo wget https://raw.githubusercontent.com/erjosito/IaC-Test/master/apple-touch-icon.png -P /var/www/html/
sudo wget https://raw.githubusercontent.com/erjosito/IaC-Test/master/favicon.ico -P /var/www/html/

