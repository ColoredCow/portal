## Installation Guidelines :rocket:

1. Clone this repository and move to `portal` directory
   ```sh
   git clone https://github.com/coloredcow-portal/portal
   cd portal
   ```

2. Install dependencies
   ```sh
   composer install 
   ```
   ```
   npm install
   ```

3. npm build
   ```sh
   npm run dev
   ```
    A possible error may arise with `cross-env`. So try running the following commands.
   - To clear a cache in npm, we need to run the npm cache command in our terminal.
   ```sh
   npm cache clear --force
   ```
   - Then, 
   ```sh
   npm install cross-env
   
   npm install
   ```
   - Finally try running `npm run dev`


4. Copy `.env.example` as `.env`


5. Run the following command to add a key
   ```sh
   php artisan key:generate
   ```

6. Add the following settings in `.env` file:
    1. Laravel app configurations
    ```sh
    APP_NAME="ColoredCow Portal"
    APP_ENV=local
    APP_DEBUG=true
    APP_URL=http://portal.test
    ```

    2. Database configurations

        Make sure you have a database created in your local server.
        For more info check this [link](https://www.youtube.com/watch?v=4geOENi3--M)

    ```
    DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
    ```


    3. Google configurations _(optional)_
    ```
    GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, GOOGLE_CLIENT_CALLBACK, GOOGLE_CLIENT_HD, GOOGLE_API_KEY, GOOGLE_APPLICATION_CREDENTIALS, GOOGLE_SERVICE_ACCOUNT_IMPERSONATE
    ```

    4. ColoredCow Website Configurations

        In case you want to use website integration functionality, then you need to enable `WORDPRESS_ENABLED` as `true` and add wordpress database configurations.

    ```
    DB_WORDPRESS_DATABASE, DB_WORDPRESS_USERNAME, DB_WORDPRESS_PASSWORD, DB_WORDPRESS_PREFIX, WORDPRESS_ENABLED=true
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
    2. Module

    Seed the modules:
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

       - Go to `C:\xampp\apache\conf\extra\httpd-vhosts.conf` and add the following code snippet at the end of the file:
        Copy the absolute file path for the `public` directory of the project and paste it below where `your_project_path` is written. For example, your project path may look like `C:/xampp/htdocs/portal/public`.

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
