## Prerequisites

For all the beginners that are starting on the portal, this is for you to get started.

### 1. Git :cat:
Git should come pre-installed in Linux and macOS. For Windows, use [this link](https://git-scm.com/download/win)
After you've successfully installed, you can verify the installation using:

```sh
git --version
# git version 2.33.0.windows.2
```

### 2. PHP, MySQL, Apache:running:
Portal uses PHP v8.2. You can install it using one of the following ways:

1. XAMPP (Windows and Linux)
    - If you prefer using XAMPP, you can download the full stack with right PHP version from [this link](https://www.apachefriends.org/download.html). 
    - If you already have XAMPP installed for Windows, refer [this link](https://stackoverflow.com/questions/45790160/is-there-way-to-use-two-php-versions-in-xampp) for switching to the correct PHP version.
    - If you already have XAMPP installed for Ubuntu, refer [this link](http://www.facweb.iitkgp.ac.in/dashboard/docs/use-different-php-version.html)for switching to the correct PHP version.
    - Run the downloaded installer and follow the on-screen instructions to install XAMPP.
    - During installation, make sure to select Apache, MySQL, PHP, and phpMyAdmin components.
    - To configure XAMPP, launch the XAMPP control panel. Start both the Apache and MySQL services.
    - Open the httpd.conf file in the Apache configuration directory (usually located in the apache folder of your XAMPP installation).
    - Make sure the Listen 80 and ServerName localhost lines are correctly configured.
    - uncomment the `;extension=openSSL` by removing ";" before it in your PHP configuration (php.ini) file located in the php folder of your XAMPP installation.
    - Save all the configuration changes you've made.

2. WAMP (Windows)
    - If you prefer using WAMP Windows(64-bit and 32-bit), you can download from [this link](https://www.wampserver.com/en/download-wampserver-64bits).
   A possible error may arise with openSSL extension in older versions. It should be enabled from your 'php.ini' file. To enable it, use the following steps:
   - Edit the system environment variables by right-clicking your windows icon most likely on the bottom-left of your screen, click on system, on the right under related settings click on Advanced System Settings, under Advanced tab click on Environment Variables, under System variables click on new or edit, to add new click on new and in th variable name write your phpversion eg php8.0.26 or just php, click on browse directory go to this pc / local disk c:/wamp/bin/php and select a php version directory you want to use use any greater than 7, click ok and the path of your selected PHP version will be set.
   - 'php.ini' can be found in thispc/localdisk c/wamp/bin/phpversion you have selected
   - In 'php.ini' (older versions), if ";extension=openSSL" is present, uncomment the ";extension=openSSL" by removing ";" before it.
   - The WAMP users have to right click on the server icon in the toolbar, and choose ‘Restart all services’ after making changes to the 'php.ini' file.
   - Run this command in the root directory of your project if composer already installed on your system:
      ```sh
      composer update
      ```
   - If the user is working in VSCode, possible errors may arise because of path, as may not be able to access the selected PHP version from its terminal.
   
3. MAMP (macOS)
    - If you prefer using MAMP, you can download with all the PHP version from [this link](https://www.mamp.info/en/downloads/)this link for Windows and MacOS.
    -To use the MAMP php as main php, refer[this link](https://stackoverflow.com/questions/4262006/how-to-use-mamps-version-of-php-instead-of-the-default-on-osx) for switching into the MAMP php.
4. After you've successfully installed, you can verify the installation using:

```sh
php -v
# output should be something like
# PHP 8.2.0 (cli) (built: Dec  9 2022 16:30:32) (NTS)
```
### 3. Steps on how to connect to MySQL database in your phpMyAdmin:running:
Before you start building PHP connection to MySQL database you need to know what phpMyAdmin is. It’s a control panel from where you can manage the database that you’ve created.

1. Open your browser and go to localhost/phpmyadmin.

2. Just click Login

3. At the top click databases.

4. In the new window, name your database as per your need, we are naming it “portal”. Now select Collation as utf8_general_ci. Now click on Create and your database will be created.

5. The newly created database will be empty now, as there are no tables in it.

6. Create a Folder in htdocs -
Now, locate the folder where you installed XAMPP and open the htdocs folder (usually c:/xampp). Create a new folder inside c:/xampp/htdocs/ and name it “portal” we will place web files in this folder.

- Why we have created a folder in htdocs?
  - XAMPP uses folders in htdocs to execute and run your PHP sites.

- For WAMP - Add your practice folder in c:/wamp/www folder.

7. For both XAMP and WAMP:
  If you’re asked to log in into your phpMyAdmin, use the username “root” and enter your root password. If you haven’t set one yet, you can leave it blank.

  For MAMP:
  Name: This is the host name. The default host is ‘localhost’.

  Username: This is your MySQL username. Your MySQL username will be ‘root’ if you have not changed the default username setup in MAMP.

  Password: This is your MySQL password.Your MySQL username password will be ‘root’ if you have not changed the default password setup in MAMP.

### 4. (Optional) If you are using TablePlus :running:

TablePlus is an easy-to-use database manager for Windows and Mac.

1. Download and Install TablePlus.
  - For Mac - [Download TablePlus](https://tableplus.com/release/osx/tableplus_latest)
  - For Windows - [Download TablePlus](https://tableplus.com/release/windows/tableplus_latest)

2. Create a New Connection -
Choose “Create a new connection…” then pick MySQL and click Create.

3. Copy the host, socket, database name, username, and password into the MySQL Connection window from the .env file in the root folder of your project.

4. Check “Use socket” before copying the socket details.

5. After copying your site details from Local, click “Test”. You should see several green fields if the connection was established successfully. If so, click “Connect” and start editing!

### 5. Composer :running:

For MacOS:
- [Composer v2.0](https://getcomposer.org/download)

For Windows:
- [Composer v2.0](https://getcomposer.org/doc/00-intro.md#installation-windows)

For Linux:
- [Composer v2.0](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos)

After you've successfully installed, you can verify the installation using:
```sh
composer --version
# output should be something like
# Composer version 2.1.6 2021-08-19 17:11:08
```

In case your composer version is different, run this command to change the version 
```sh
composer self-update 2.1.6
```

### 6. Nodejs :running:
For (Windows, Ubuntu, macOS)
- [Nodejs v18](https://nodejs.org/download/release/v18.16.0/).
Download and install the file with .msi extension if on windows. After you've successfully installed, you can verify the installation using:
```sh
npm -v
# output should be something like
# 9.5.1

node -v
#output should be somthing like
#v18.16.0
```

### 7. Code Formatter :butterfly:

Install the following extensions and packages based on the code editor you use:

- Visual Studio Code Editor:
  - [Prettier - for JS, CSS, HTML files](https://prettier.io/)
  - [Laravel Blade Snippets for Blade files](https://marketplace.visualstudio.com/items?itemName=onecentlin.laravel-blade)
  - [Laravel Extra Intellisense](https://marketplace.visualstudio.com/items?itemName=amiralizadeh9480.laravel-extra-intellisense)
  - [PHP Intelephense](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client)
  - [PHP CS Fixer](https://marketplace.visualstudio.com/items?itemName=junstyle.php-cs-fixer)

- Sublime Code Editor:
  - [PHP formatting - PHPfmt](https://packagecontrol.io/packages/phpfmt)
  - [Laravel Blade Snippets for Blade files](https://marketplace.visualstudio.com/items?itemName=onecentlin.laravel-blade)
  - [Prettier - for JS, CSS, HTML files](https://prettier.io/)




## Learning :book:

There are some topics and tools you need to know to prior to work
in portal so please make sure to check this out.


### 1. Version Control System :computer:
  Version control, also known as source control, is the practice of tracking and managing changes to software code.

  More about [version control system](https://www.atlassian.com/git/tutorials/what-is-version-control)

### 2. Git :cat:

- [Understanding Git](https://hackernoon.com/understanding-git-fcffd87c15a3)

- [Version control and Git](https://laracasts.com/series/git-me-some-version-control)

- [What is Git](https://www.atlassian.com/git/tutorials/what-is-git)

### 3. Git and GitHub :running:

- [Git, GitHub and Development](https://product.hubspot.com/blog/git-and-github-tutorial-for-beginners)

### 4. Laravel Modules :butterfly:

This project uses Laravel Modules, so a basic understanding of the commands is recommended:

- [Laravel Module Utility Commands](https://nwidart.com/laravel-modules/v1/advanced-tools/artisan-commands)

### 8. Automated Testing :computer:

This project uses Cypress for automated testing, so a basic understanding of the writing test cases is recommended:

- [Introduction to Cypress](https://github.com/ColoredCow/portal/blob/master/docs/testing.md)
- [Writing Your First Test](https://docs.cypress.io/guides/getting-started/writing-your-first-test)
- [Testing Your App](https://docs.cypress.io/guides/getting-started/testing-your-app#Step-1-Start-your-server)

