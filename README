# Covid-19 Contact-Log

## Why?

Covid-Contact-Log is a simple self-hosted log-tool for you and your household to make a note when you've met someone.
In case one of you get's this nasty piece of virus, you can provide your local health authority with a
list of persons who you've met, even those that don't have a Corona-App (or a smartphone at all).

## Requirements?
As of right now:

* PHP 7.0 (and higher)
* MySQL-Server (anything within the last 10 years should do)
* WebServer (Apache, NGINX, or whatever floats your boat)

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
separate entries. My reasoning for this: You and your kids/spouse/etc.
live in the same household. So if one of you has met someone,
the other one probably has too. And in the serious and unfortunate
case that one of your hosehold contracted Covid, it shouldn't be to
hard to separate all the entries.

Nonetheless, to provide everyone with their own password, just
add users to the user-array in your ```config.php```.
To create user entries, please use the provided script in ```tools/create_user.php```.

## Languages

This script is currently available in English and German.
If you find this little app useful and want to provide further
translations, i'd be happy to add them.
Just make a copy of ```translatations/en.php``` and exchange all
those english strings for the appropriate ones in your own beautiful language.


