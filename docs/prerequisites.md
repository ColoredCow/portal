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
Portal uses PHP v7.4. You can install it using one of the following ways:

1. XAMPP (Windows and Linux)
    - If you prefer using XAMPP, you can download the full stack with right PHP version from [this link](https://www.apachefriends.org/download.html)
    - If you already have XAMPP installed for Windows, refer [this link](https://stackoverflow.com/questions/45790160/is-there-way-to-use-two-php-versions-in-xampp) for switching to the correct PHP version.
    - If you already have XAMPP installed for Ubuntu, refer [this link](http://www.facweb.iitkgp.ac.in/dashboard/docs/use-different-php-version.html)for switching to the correct PHP version.
   
2. WAMP (Windows)
    - If you prefer using WAMP Windows(64-bit and 32-bit), you can download from [this link](https://www.wampserver.com/en/download-wampserver-64bits).
   A possible error that may arise with openSSL extension. It should be enabled from your 'php.ini' file. To enable it, use the following steps:
   - Edit the system environment variables and set the path of your selected PHP version.
   - In 'php.ini', uncomment the ";extension=openSSL" by removing ";" before it.
   - The WAMP users have to right click on the server icon in the toolbar, and choose ‘Restart all services’ after making changes to the 'php.ini' file.
   - Run this command in the root directory of your project:
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
# PHP 7.4.21 (cli) (built: Aug  5 2021 15:34:00) ( NTS )
```
### 3. Steps on how to connect to MySQL database in your phpMyAdmin:running:
Before you start building PHP connection to MySQL database you need to know what phpMyAdmin is. It’s a control panel from where you can manage the database that you’ve created. 

1. Open your browser and go to localhost/phpMyAdmin.

2. When you first installed XAMPP/WAMP, it only created the username for it to be accessed, you now have to add a password to it by yourself. For this, you have to go to User account.

3. Now click Edit privileges and go to Change Admin password, type your password there and save it. Remember this password as it will be used to connect to your Database.

Note: It is not necessary to change the password to access databases on the localhost. It is a good practice and that is why we have used a password.(For this poject, it is not necessary to have one).

4. Create Database - 
Now return to the homepage of phpMyAdmin. Click the New button to create a new database.

5. In the new window, name your database as per your need, we are naming it “portal”. Now select Collation as utf8_general_ci. Now click on Create and your database will be created.

6. The newly created database will be empty now, as there are no tables in it.

7. Create a Folder in htdocs -
Now, locate the folder where you installed XAMPP and open the htdocs folder (usually c:/xampp). Create a new folder inside c:/xampp/htdocs/ and name it “portal” we will place web files in this folder. 

- Why we have created a folder in htdocs? 
  - XAMPP uses folders in htdocs to execute and run your PHP sites.

- For WAMP - Add your practice folder in c:/wamp/www folder.

8. For both XAMP and WAMP:
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

### 6. Nodejs :running:
For (Windows, Ubuntu, macOS)
- [Nodejs v14 or higher](https://nodejs.org/en/download/).
After you've successfully installed, you can verify the installation using:
```sh
npm -v
# output should be something like
# 6.14.15

node -v
#output should be somthing like
#v14.17.6
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

