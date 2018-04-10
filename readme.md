# Online File Manager
Online file manager is basically an open source cloud storage created with Laravel, PHP, jQuery and JS. File management system allows you to share your files with co-workers and customers if you wish so.

## About
The file manager's usage is quite easy and straight forward.

- Create directories and fill them with files.
- Control user privileges to access directories and upload files.
- Download directories as zip files.

## Installation guide

To get file manager to work, you need to run following installation steps.

### 1.0 [Xampp](https://www.apachefriends.org/index.html)
You need MySQL-database to use file manager, you can get one from [here](https://www.apachefriends.org/index.html).
Run the default installation.

### 2.0 [Composer](https://getcomposer.org/download/)
Install composer using following commands in your terminal.

**2.1 Local installation**
Move to the location where you want to install composer, and run following commands one line at a time.
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```
**2.2 Global installation [Recommended]**
Run the same commands as in Local installation and after that run following command
```
mv composer.phar /usr/local/bin/composer
```
Run command: ```composer``` to see if composer is globally installed.
If you see composer text with list of all usable commands, then the installation is successful.

### 3.0 [Git](https://git-scm.com/)
- Download and run default installation

### 4.0 [Laravel](https://laravel.com/docs/5.6/installation)
After installing composer successfully run: ```composer global require "laravel/installer"```

**4.1 Download file manager**
- Open terminal and change your current working directory to the location where you want to download the file manager.
- Run following command ```git clone git@github.com:MaikelTalts/Laravel_project_2017.git```

**4.2 Install composer**
- In terminal change your current directory inside recently downloaded Laravel_project_2017
- Run command ```composer install``` or ```php composer.phar install```.

**4.3 .env file**
- Rename ```.env.example``` file as ```.env``` and fill it with your database information, if you don't know it open xampp and start MySQL database and apache server and head to ```http://localhost/phpmyadmin/```.
- Add ```ROOTFOLDER=public/``` at the end of .env file.
- Run command: ```php artisan key:generate```.

**4.4 Migrations**
- Open XAMPP and start the MySQL Database.
- Open terminal and head to the extraction point. For example: ```cd /Applications/XAMPP/xamppfiles/htdocs/filebrowser``` and run command: ``` php artisan migrate ```

**4.5 start the file manager**
- After migration run command ```php artisan serve ```
- Head to ```localhost:8000``` in your browser.

Login with E-mail:```admin@email.com``` and Password:```1q2w3e4r```
