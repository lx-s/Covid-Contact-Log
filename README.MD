# :family: Covid-19 Contact-Log

Covid-Contact-Log is a simple, self-hosted log-tool for ...

## :raised_hand: Wait! Pics or I stop reading!
![Screenshot](./raw/screenshot.png?raw=true "CCL Screenshot")

Since we've got that out of the way~

## :thinking: Why?

Covid-Contact-Log is a simple, self hosted log tool for you and your household
to make a quick note of who you met when. The idea for this tool came from
a guest article of the german virologist Christian Drosten in the german newspaper
"Die Zeit", titled "Ein Plan für den Herbst".

Within that article he states that everyone should write a contact-journal to
help local health authorities detect covid clusters. To make this easier for me
and my family, I decided to write a simple web page where my wife and I can easily
log our daily contacts quickly.

## :clipboard: Features

 * Logs names and timestamps
 * Also displays aforementioned logged names and timestamps
 * Programmer-Art™ interface
 * KISS access management
 * Responsive interface
 * Available in German and English.

## :computer: Requirements?

Currently:

* PHP 7.0 (and higher)
* MySQL-Server (anything within the last 10 years should do)
* WebServer (Apache, NGINX, or whatever floats your boat and supports PHP)

## :floppy_disk: How to install

Since this was written quickly and mostly for myself, there isn't
a fancy install script that guides you through the setup.
Nonetheless, setting this script up is not that hard:

### Debian (lxc container behind reverse proxy - ssl handled by revproxy)
```

apt update && apt install libapache2-mod-php7.3 php7.3-intl php7.3-mysql mariadb-server pwgen
# now either unzip release or use the latest dev state to /var/www/html
# i choose git
apt install git
cd /var/www/html
git clone https://github.com/lx-s/Covid-Contact-Log.git
cd /var/www/html/Covid-Contact-Log/
mysql -e "CREATE DATABASE corona;"
pass=$(pwgen -s 16 1)
mysql -e "CREATE OR REPLACE USER 'corolog' IDENTIFIED BY '${pass}';" && mysql -e "GRANT ALL ON corona.* TO 'corolog';"
mysql -u corolog -p${pass} corona < /opt/Covid-Contact-Log/install/schema.sql && echo "DB installed, random DB Password set & configured"
if [ ! -f config.php ]; then
  sed -re "s/(.*'DB_USER', ')/\1corolog/g" config.sample.php \
  | sed -re "s/(.*'DB_NAME', ')/\1corona/g" \
  | sed -re "s/(.*'DB_PASSWORD', ')/\1${pass}/g" > config.php
fi

echo "
<VirtualHost *:80>
        ServerName your.domain.name
        ServerAdmin your@email
        DocumentRoot /var/www/html/Covid-Contact-Log/
</VirtualHost>
" > /etc/apache2/sites-available/coronalog.conf
a2ensite coronalog && apachectl configtest && systemctl reload apache2

# user password:
pass=$(pwgen -s 16 1) && echo -n "${pass}" | sha256sum && echo "user password to go into \$cclUsers_ is ${pass}"
```

1. Create a database
2. Import the schema found at ```install/schema.sql```
3. Unzip the app into a directory of your choice
4. Copy ```config.sample.php``` to ```config.php``` and enter your database
   credentials (and everything else)
5. Start logging like crazy!

## :floppy_disk: How to upgrade

To upgrade a installation, delete all files **except** your `config.php`.
Afterwards unzip this app into the directory of your ```config.php```.

## :information_desk_person: User Management

I've decided not to implement a complete user management, with
separate log-entries for each user.
My reasoning for this: You and your kids/spouse/etc.
live in the same household. So if one of you has met someone,
the other one probably has too. And in the serious and unfortunate
case that one of your household-members contracted Covid,
it shouldn't be diffcult to separate all the entries.

User-credentials provide a convenient way to let everyone have
their own password, but that's it. If you want to use this feature,
add users to the user-array in your ```config.php```.
To create user entries, please use the provided script in ```tools/create_user.php```.

## :milky_way: Languages

This script is currently available in **English** and **German**.
If you find this little app useful and want to provide further
translations, I'd be happy to add them.

To begin, just make a copy of ```translations/en.php``` and exchange all
those english strings for the appropriate ones in your own beautiful language.
