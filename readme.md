# Online File Management System
Online file manager is basically an open source cloud storage created with Laravel. File management system allows you to share your files with co-workers or customers.

## About
 Create directories where to upload your files, then give privileges for users to access that folder or to upload files in it.

- Create directories and then fill them with files.
- Manage user privileges to access directories and upload files.
- Download directory structures as zip files.

## Install guide

To get file manager to work, you need to run following installation steps.

### 1.0 Xampp
You need a MySQL-database to use file manager, you can get one from [here](https://www.apachefriends.org/index.html).
Run the default installation.

### 2.0 Composer
Install composer using following commands in your Mac terminal or PC Command Prompt

**2.1 Local installation**
Move to the location where you want to install composer. And run following commands one line at a time.
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```
**2.2 Global installation**
Run the same commands as in Local installation and after that run following command
```
mv composer.phar /usr/local/bin/composer
```
Now test ifthe composer is globally installed and run command:
```
composer
```
If you see composer text with list of all usable commands, then the global installation is successful.

### 3.0 Laravel
After installing installing composer successfully run following command.
```
composer global require "laravel/installer"
```

- Download the the Laravel_project_2017 as zip file, and extract it to XAMPP/htdocs folder.
- Start XAMPP and start the MySQL Database.
- Open terminal or command prompt and head to the place where you extracted the projext zip file. For example: cd /Applications/XAMPP/xamppfiles/htdocs/filebrowser and run command:
- ``` php artisan migrate ``` 
