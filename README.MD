# Covid-19 Contact-Log

## Why?

Covid-Contact-Log is a simple self-hosted log-tool for you and your household
to make a quick note when you've met someone. The idea for this tool came from
Christian Drosten's (a german virologist) guest article in the german newspaper
"Die Zeit", titled "Ein Plan für den Herbst".

Within that article he states, that everyone should write a contact-journal to
help local health authorities detect covid clusters. To make this easier for me
and my family, I decided to write a simple web-page where my wife and I can log
our daily contacts quick and in a simple format.

## Requirements?

Currently:

* PHP 7.0 (and higher)
* MySQL-Server (anything within the last 10 years should do)
* WebServer (Apache, NGINX, or whatever floats your boat and supports PHP)

## How to install

Since this was written quickly and mostly for myself, there isn't
a fancy install script that guides you through the setup.   
Nonetheless, setting this script up is not that hard:

1. Create a database
2. Import the schema found at ```install/schema.sql```
3. Unzip the app into a directory of your choice
4. Copy ```config.sample.php``` to ```config.php``` and enter your database
   credentials (and everything else)
5. Start logging like crazy!

## User Management

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

## Languages

This script is currently available in English and German.
If you find this little app useful and want to provide further
translations, I'd be happy to add them.

To begin, just make a copy of ```translatations/en.php``` and exchange all
those english strings for the appropriate ones in your own beautiful language.
