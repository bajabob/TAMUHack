#Installation
------------

#### 1. XAMPP
------------------
* We highly recommend that you setup a web server locally on your machine. Having the ability to test your code locally is invaluable. [XAMPP](http://www.apachefriends.org/index.html), is a great easy to use utility with everything you will need to run PHP, MySQL and of course Apache.


#### 2. Virtual Host(Windows Environment)
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
    <Directory "C:\the\path\to\your\code">
		Order Allow,Deny
		Allow from all
		Require all granted
	</Directory>
</VirtualHost>
````
* Now, open notepad as administrator and open this file C:\Windows\System32\drivers\etc\hosts.  
>   Note: When you opening the file, you might have to select "all files" in order to see it. Also in Windows 8, you might have to add an exception to Windows Defender. You might also have to right click on the hosts file and unselect the "Read-only" option. 

* For this example, you will then add the code below to the hosts file and save it.

````
127.0.0.1 tamutest

````
> Note: If you made the hosts file writeable or added an exception to Windows Defender, please make sure you change it back once you have added your testing site to the hosts file for your own security and protection.

* Run to XAMPP Control Panel and run Apache and MySQL
* Go to localhost on your browser and click on the link that says "Security". Set up your passwords

* If you have trouble setting it up, you can always see this [video](https://www.youtube.com/watch?v=JZ-V0fmBlrg).

#### 3. MySQL
------------------
* The current database is MySQL, make sure your local environment can support this.

* Database: tamuhack_db
* User: tamuhack_db
* Pass: anything-you-want
* Upon choosing a password, make a copy of the config "/tamuhack_includes/application/configs/temp.application.ini" in the same folder and name it "application.ini". 
* Open your new config file and add your created password.
* Import the database from "tamuhack_includes/application/db/tamuhack_db.sql"

You should at this point be able to use the site locally on your machine. 
