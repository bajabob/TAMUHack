#Installation
------------

To get started:
* We highly recommend that you setup a web server locally on your machine. Having the ability to test your code locally is invaluable. [XAMPP](http://www.apachefriends.org/index.html), is a great easy to use utility with everything you will need to run PHP, MySQL and of course Apache.
* Once XAMPP is installed, find a tutorial online to setup a virtual host. This will allow you access your test site via URL. For instance, 'http://tamuhack'
* The current database is MySQL, make sure your local environment can support this.

#### MySQL
------------------
* Database: tamuhack_db
* User: tamuhack_db
* Pass: anything-you-want
* Upon choosing a password, make a copy of the config "/tamuhack_includes/application/configs/temp.application.ini" in the same folder and name it "application.ini". 
* Open your new config file and add your created password.
* Import the database from "tamuhack_includes/application/db/tamuhack_db.sql"

You should at this point be able to use the site locally on your machine. 
