# Online Filebrowser
Online Filebrowser is basically an open source cloud storage created with Laravel, PHP, jQuery and JS. Filebrowser allows you to share your files with co-workers and customers if you wish so.

## About
The filebrowser's usage is quite easy and straight forward.

- Create directories and fill them with files.
- Control user privileges to access directories and upload files.
- Download directories as zip files.

## Installation guide
Run the following installation steps
If you already have XAMPP, composer and git on your computer then head straight to step **4.0**

### 1.0 [Xampp](https://www.apachefriends.org/index.html)
You need MySQL-database to use filebrowser, you can get one from [here](https://www.apachefriends.org/index.html).
Run the default installation.

### 2.0 [Composer](https://getcomposer.org/download/)

**2.1 Local installation**
Open your terminal and change your current directory to where you want to install composer and run following commands one line at a time.
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```
Run command: ```php composer.phar``` to see if your installation was successful.

**2.2 Global installation [Recommended]**
Run the same commands as in local installation and after that run following command
```
mv composer.phar /usr/local/bin/composer
```
Run command: ```composer``` to see if composer is globally installed.

### 3.0 [Git](https://git-scm.com/)
- Download and run default [git](https://git-scm.com/) installation

### 4.0 [Laravel](https://laravel.com/docs/5.6/installation)

**4.1 Download filebrowser**
- Open terminal and change your current directory to where you want to download the filebrowser
- Run following command ```git clone git@github.com:MaikelTalts/Filebrowser.git```

**4.2 Install composer**
- In terminal open recently downloaded Laravel_project_2017 directory
- Run command ```composer install``` or ```php composer.phar install```.

**4.3 Database**
- Open Xampp and start MySQL Database and apache server.
- Head to http://localhost/phpmyadmin/ and create new database for filebrowser.
- **Recommended** Create new user for your database instead of using ```root``` and ``` ```, you need that created user at the next step.

**4.4 .env file**
- Rename ```.env.example``` file as ```.env``` and fill it with your database information.
- Run command: ```php artisan key:generate```.
- Add ```ROOTFOLDER=public/``` at the end of .env file and save your changes.

**4.5 Migrations**
- Run command: ``` php artisan migrate ```

**4.6 start the filebrowser**
- After migration run command ```php artisan serve ```
- Head to ```localhost:8000``` in your browser.

Login with E-mail:```admin@email.com``` and Password:```1q2w3e4r```
