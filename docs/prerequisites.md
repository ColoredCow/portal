## Prerequisites and Learning :book:

For all the beginners that are starting on the portal this is for you to get started.

There are some topics and tools you need to know to prior to work in portal so please make sure to check this out.

### 1. Version Control System :computer:
  Version control, also known as source control, is the practice of tracking and managing changes to software code.

  More about [version control system](https://www.atlassian.com/git/tutorials/what-is-version-control)

### 2. Git :cat:

- [Understanding Git](https://hackernoon.com/understanding-git-fcffd87c15a3)

- [Version control and Git](https://laracasts.com/series/git-me-some-version-control)

- [What is Git](https://www.atlassian.com/git/tutorials/what-is-git)

### 3. Git and GitHub :running:

- [Git, GitHub and Development](https://product.hubspot.com/blog/git-and-github-tutorial-for-beginners)

### 4. PHP :running:
PHP v7.3 or v7.4 is needed.

You can install it with the following ways:
1. XAMPP
    - If you prefer using XAMPP, you can download the full stack with right PHP version from [this link](https://www.apachefriends.org/download.html)
    - If you already have XAMPP installed, refer [this link](https://stackoverflow.com/questions/45790160/is-there-way-to-use-two-php-versions-in-xampp) for switching to the correct PHP version.
    - If user face any issues or make any changes in the project, should restart the Apache services.
2. WAMP
    - If you prefer using WAMP, you can download from [this link](https://www.wampserver.com/en/download-wampserver-64bits).
   A possible error that may arise with openSSL extension. It should be enabled from your 'php.ini' file. To enable it, use the following steps:
   - Edit the system environment variables and set the path of your selected PHP version.
   - In 'php.ini', uncomment the ";extension=openSSL" by removing ";" before it.
   - The WAMP users have to right click on the server icon in the toolbar, and choose ‘Restart all services’ after making changes to the 'php.ini' file.
   - Run this command in the root directory of your project:
      ```sh
      composer update
      ```
   - If the user is working in VSCode, possible errors may arise because of path, as may not be able to access the selected PHP version from its terminal.

### 5. Composer :running:

- [Composer v2.0](https://getcomposer.org/download)

### 6. Nodejs :running:

- [Nodejs v14 or higher](https://nodejs.org/en/download)

### 7. Laravel Modules :butterfly:

This project uses Laravel Modules, so a basic understanding of the commands is recommended:

- [Laravel Module Utility Commands](https://nwidart.com/laravel-modules/v1/advanced-tools/artisan-commands)

### 8. Code Formatter :butterfly:

Add the plugins mentioned below for automatic code styling:

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
