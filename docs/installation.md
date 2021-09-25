## Installation Guidelines :rocket:

1. Clone this repository and move to `portal` directory
   ```sh
   git clone https://github.com/coloredcow-portal/portal
   cd portal
   ```

2. Install dependencies
   ```sh
   composer install
   npm install
   ```

3. npm build
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


4. Copy `.env.example` as `.env`


5. Run the following command to add a key
   ```sh
   php artisan key:generate
   ```
   Note- Make sure that the 'php.ini' file in XAMPP/WAMP has this code uncommented/written


    `extension=gd`


6. Add the following settings in `.env` file:
    1. Laravel app configurations
    ```sh
    APP_NAME="ColoredCow Portal"
    APP_ENV=local
    APP_DEBUG=true
    APP_URL=http://portal.test
    ```

    2. Database configurations
     Make sure you have a database created in your local server. For more info check this [link](https://www.youtube.com/watch?v=4geOENi3--M).

    ```sh
    DB_CONNECTION=
    DB_HOST=
    DB_PORT=
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=
    ```
    **Note:** Use the default values for MySQL database in `.env` file
    ```
    DB_USERNAME=root
    DB_PASSWORD=
    ```

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

7. Run migrations
    ```sh
    php artisan migrate
    ```

8. Run seeders
    1. Portal
        ```sh
        php artisan db:seed
        ```
        In case you want to run a specific seeder class, use the ```--class``` option:
        ```sh
        php artisan db:seed --class=CLASSNAME
        ```
    2. Module:
        ```sh
        php artisan module:seed
        ```
        In case you want to run seeders inside a specific module, run:
        ```sh
        php artisan module:seed MODULE_NAME
        ```

9. Setup Virtual Host
    1. For XAMPP:
        - Go to `C:\WINDOWS\system32\drivers\etc\` and open the `hosts` file in notepad (run as administrator). Add the following line at the end:
            ```
            127.0.0.1      portal.test
            ```

        - Go to `C:\xampp\apache\conf\extra\httpd-vhosts.conf` and add the following code snippet at the end of the file. Copy the absolute file path for the `public` directory of the project and paste it below where `your_project_path` is written. For example, your project path may look like `C:/xampp/htdocs/portal/public`.
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
    
    2. For MAMP(Mac OS)
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
            sudo nano /etc/apache2/httpd.conf
            ```
            And search for `vhosts` and uncomment line like this
            ```sh
            # Virtual hosts
            # Include /private/etc/apache2/extra/httpd-vhosts.conf
            ```
            Change above to:
            ```sh
            # Virtual hosts
            Include /private/etc/apache2/extra/httpd-vhosts.conf
            ```
          - Go to vhost file in the terminal 
            ```sh
            sudo nano /etc/apache2/extra/httpd-vhosts.conf
            ```
            Add the following line at the end of the file: 
            Copy the absolute file path for the `public` directory of the project and paste it below where `your_project_path` is written. For example, your project path may look like `/Application/MAMP/htdocs/portal/public`.

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
          - Restart MAMP. Next, open this url in your browser: http://portal.test

          - In case you see a 403 Forbidden error in Apache, try this instead:
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
10. Login to the portal using the newly created user in the database. Go to `http://localhost/phpmyadmin/index.php` and search for the `users` table and you can find the user email in it. The default password to log in is `12345678`.
