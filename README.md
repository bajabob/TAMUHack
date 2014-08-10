#Installation
------------

#### 1. XAMPP
------------------
* We highly recommend that you setup a web server locally on your machine. Having the ability to test your code locally is invaluable. [XAMPP](http://www.apachefriends.org/index.html), is a great easy to use utility with everything you will need to run PHP, MySQL and of course Apache.


#### 2. Virtual Host
------------------
* Once XAMPP is installed, setup a virtual host. This will allow you access your test site via URL. For instance, 'http://tamuhack'. Assuming you installed XAMPP in C:\xampp, go to C:\xampp\apache\conf\extra\httpd-vhosts.­conf and open the file. Copy the code here and paste it below the dummy text in the vhosts.conf file. Change it so it matches your needs.  

```` 
<VirtualHost *:80>
    DocumentRoot "C:\xampp\htdocs"
    ServerName localhost
</VirtualHost>

<VirtualHost *:80>
    ServerAdmin tamutest
    DocumentRoot "C:\the\path\to\your\code"
    ServerName tamutest
    ErrorLog "logs/dummy-host2.example.com-error.log"
    CustomLog "logs/dummy-host2.example.com-access.log" common
</VirtualHost>
````
* Now, open notepad as administrator and open this file C:\Windows\System32\drivers\etc\hosts.
> Note: you might have to select "all files" in order to see it.
For this example, you will then add this code below and save the file. 

````
127.0.0.1 tamutest

````
* go to localhost on your browser and click on the link that says "Security". Set up your passwords

* If you have trouble setting it up, you can always see this [video](https://www.youtube.com/watch?v=JZ-V0fmBlrg).
* The current database is MySQL, make sure your local environment can support this.

#### 3. MySQL
------------------
* Database: tamuhack_db
* User: tamuhack_db
* Pass: anything-you-want
* Upon choosing a password, make a copy of the config "/tamuhack_includes/application/configs/temp.application.ini" in the same folder and name it "application.ini". 
* Open your new config file and add your created password.
* Import the database from "tamuhack_includes/application/db/tamuhack_db.sql"

You should at this point be able to use the site locally on your machine. 
