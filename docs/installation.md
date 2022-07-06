## Installation Guidelines :rocket:

Before you start following the guidelines, make sure to go through the [prerequisites guide](./prerequisites.md) to install the required tools and packages on your machine.

**Note:** If you are a Windows user, use GitBash or PowerShell instead of the command prompt.
1. Navigate to the right directory where your project will be locally saved
    - For WAMP:
        ```sh
        cd C:\wamp64\www\
        ```
    - For XAMPP:
        ```sh
        cd C:\xampp\htdocs\
        ```
    - For MAMP(macOS):
        ```sh
        cd /Application/MAMP/htdocs/
    ```
    Note- phpMyAdmin/PHP, apache, and MySQL comes preinstalled with the  WAMP, XAMPP package, that is going to be used later on in this project, so no need to install these files separately. 

2. Clone this repository and move to `portal` directory
   ```sh
   git clone https://github.com/coloredcow/portal
   cd portal
   ```

3. Install dependencies
   ```sh
   composer install
   npm install
   ```

4. npm build
   ```sh
   npm run dev
   ```
    A possible error may arise with `cross-env`. So try running the following commands.
    - To clear a cache in npm, we need to run the npm cache command in our terminal and install cross-env.
   ```sh
   npm cache clear --force
   npm install cross-env

   npm install
   npm run dev
   ```


5. Make a copy of the `.env.example` file in the same directory and save it as `.env`:
     ```sh
    cp .env.example .env
    ```

6. Run the following command to add the Laravel application key:
   ```sh
   php artisan key:generate
   ```
   **Note:** Make sure that the 'php.ini' file in XAMPP/WAMP has this code uncommented/written
    `extension=gd`


7. Add the following settings in `.env` file:
    1. Laravel app configurations
    ```sh
    APP_NAME="ColoredCow Portal"
    APP_ENV=local
    APP_DEBUG=true
    APP_URL=http://portal.test
    ```

    2. Database configurations
    - Create a database in your local server. Check out [this link](https://www.youtube.com/watch?v=k9yJR_ZJbvI&ab_channel=1BestCsharpblog) and skip to 0:21.
    - Configure your Laravel app with the right DB settings. Check out [this link](https://www.youtube.com/watch?v=4geOENi3--M). Relevant parts are 2:00-2:42 and 4:20-5:40.
    - Read [the story](https://docs.google.com/document/d/1sWj0F2uXkSE9oHBkChv-yC2L7P7qazsPY5sNPC1PIp4/edit) about how the team discussed which video should be in the docs

    ```sh
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=portal
    DB_USERNAME=root
    DB_PASSWORD=
    ```
    **Note:** Use the default values for MySQL database in `.env` file
    ```
    DB_USERNAME=root
    DB_PASSWORD=
    ```

    These credentials will be used when you will connect to MySQL Server whether you use XAMPP, WAMP, MAMP (PhpMyadmin) or TablePlus, the proper steps you can find here in the [prerequisites guide](./docs/prerequisites.md).

    3. _(Optional)_ Google configurations.
    ```sh
    GOOGLE_CLIENT_ID=
    GOOGLE_CLIENT_SECRET=
    GOOGLE_CLIENT_CALLBACK=
    GOOGLE_CLIENT_HD=
    GOOGLE_API_KEY=
    GOOGLE_APPLICATION_CREDENTIALS=
    GOOGLE_SERVICE_ACCOUNT_IMPERSONATE=
    ```

    4. _(Optional)_ ColoredCow website Configurations
    In case you want to use website integration functionality, then you need to enable `WORDPRESS_ENABLED` as `true` and add wordpress database configurations.

    ```sh
    DB_WORDPRESS_DATABASE=
    DB_WORDPRESS_USERNAME=
    DB_WORDPRESS_PASSWORD=
    DB_WORDPRESS_PREFIX=
    WORDPRESS_ENABLED=true
    ```

8. Run migrations
    ```sh
    php artisan migrate
    ```

9. Run seeders
    1. Portal
        ```sh
        php artisan db:seed
        ```
        _(Optional)_ In case you want to run a specific seeder class, use the ```--class``` option:
        ```sh
        php artisan db:seed --class=CLASSNAME
        ```
    2. Module:
        ```sh
        php artisan module:seed
        ```
        _(Optional)_ In case you want to run seeders inside a specific module, run:
        ```sh
        php artisan module:seed MODULE_NAME
        ```

10. Setup Virtual Host
    1. For WAMP:
        - Go to `C:\WINDOWS\system32\drivers\etc\` and open the `hosts` (not the one with ICS extension) file in notepad (run as administrator). Add the following line at the end:
            ```
            127.0.0.1      portal.test
            ```
        - Go to `C:\wamp64\bin\apache\apache2.4.46\conf\extra\httpd-vhosts.conf` and add the following code snippet at the end of the file. Copy the absolute file path for the `public` directory of the project and paste it below where `your_project_path` is written. For example, your project path may look like `C:\wamp64\www\portal\public`.
            ```apacheconf
            <VirtualHost *:80>
                ServerName portal.test
                DocumentRoot "/path/to/your/project"
                <Directory "/path/to/your/project">
                    DirectoryIndex index.php
                    AllowOverride All
                    Order allow,deny
                    Allow from all
                </Directory>
            </VirtualHost>
            ```
        - Restart WAMP. Next, open this url in your browser: http://portal.test

    2. For XAMPP:
        - Go to `C:\WINDOWS\system32\drivers\etc\` and open the `hosts` (not the one with ICS extension) file in notepad (run as administrator). Add the following line at the end:
            ```
            127.0.0.1      portal.test
            ```

        - Go to `C:\xampp\apache\conf\extra\httpd-vhosts.conf` and add the following code snippet at the end of the file. Copy the absolute file path for the `public` directory of the project and paste it below where `your_project_path` is written. For example, your project path may look like `C:\xampp\htdocs\portal\public`.
            ```apacheconf
            <VirtualHost *:80>
                ServerName portal.test
                DocumentRoot "/path/to/your/project"
                <Directory "/path/to/your/project">
                    DirectoryIndex index.php
                    AllowOverride All
                    Order allow,deny
                    Allow from all
                </Directory>
            </VirtualHost>
            ```
        - Restart XAMPP. Next, open this url in your browser: http://portal.test

    3. For MAMP(macOS):
        - Go to `etc/hosts` file or edit this in the terminal use the following command.
            ```sh
            sudo nano /etc/hosts
            ```
        - Add this line
            ```
            127.0.0.1   portal.test
            ```

        - Go to `httpd.conf` file or edit this file in the terminal itself use this command
            ```sh
            sudo nano /Applications/MAMP/conf/apache/httpd.conf
            ```
            And search for `vhosts` and uncomment line like this
            ```sh
            # Virtual hosts
            # Include Applications/MAMP/conf/apache/extra/httpd-vhosts.conf
            ```
            Change above to:
            ```sh
            # Virtual hosts
            Include Applications/MAMP/conf/apache/extra/httpd-vhosts.conf
            ```
          - Open the `vhost` file in the terminal
            ```sh
            sudo nano /etc/apache2/extra/httpd-vhosts.conf
            ```
            Add the following line at the end of the file:
            Copy the absolute file path for the `public` directory of the project and paste it below where `your_project_path` is written. For example, your project path may look like `/Application/MAMP/htdocs/portal/public`. Make sure you type '/public' at the end after your project path.

            ```apacheconf
             <VirtualHost *:80>
                 ServerName portal.test
                 DocumentRoot "/path/to/your/project/public"
                 <Directory "/path/to/your/project/public">
                     DirectoryIndex index.php
                     AllowOverride All
                     Order allow,deny
                     Allow from all
                 </Directory>
             </VirtualHost>
            ```
          - In case you are using Apache version 2.4 or above, the above code will give you a 403 Forbidden error. Make the following changes:
            ```apacheconf
            <Directory>
                # some code above
                Order allow,deny
                Allow from all
            </Directory>
            ```
            Change to:
            ```apacheconf
            <Directory>
                 # some code above
                 Require all granted
            </Directory>
            ```
           - Restart MAMP. Next, open this url in your browser: http://portal.test
11. Login to the portal using the newly created user in the database. Go to `http://localhost/phpmyadmin/index.php` and search for the `users` table and you can find the user email in it. The default password to log in is `12345678`.

12. _(Optional)_ Setup Email configuration:  

    1. Open [Mailtrap](https://mailtrap.io/) and signup/login.  

    2. Create an inbox.  

    3. Open inbox setting and choose Laravel 7+ from Integrations.  

    4. Open .env file and add the following  

        ```sh
        MAIL_DRIVER=smtp
        MAIL_HOST=smtp.mailtrap.io
        MAIL_PORT=yourPortNumber
        MAIL_USERNAME=yourMailtrapUsername
        MAIL_PASSWORD=yourMailtrapPassword
        MAIL_ENCRYPTION=tls
        MAIL_FROM_ADDRESS=senderEmailAddress
        MAIL_FROM_NAME="${APP_NAME}"
        ```
