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

### 3. Composer :running:

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

### 4. Nodejs :running:
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

### 5. Code Formatter :butterfly:

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

### 6.Automated Testing :computer:



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
