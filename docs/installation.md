## Installation Guidelines :rocket:

1. Clone this repository
```sh
git clone https://github.com/coloredcow-portal/portal
```

2. Install dependencies
```sh
composer install
```
Note: Use the php version (7.3 / 7.4) or else use the below link to download.
link(https://www.php.net/downloads.php#v7.4.22).
```
npm install
```
3. Change's in the php.ini file,
Go to your php.ini file(C:\xampp\php)
Search for openssl,
```
;extension=openssl
```
remove the colon in the front and save like this
```
extension=openssl
```
4. npm build
```sh
npm run dev
```

5. Copy `.env.example` as `.env`

6. Run the following command to add a key
```sh
php artisan key:generate
```
7. Add the following settings in `.env` file:
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

8. Run migrations
```sh
php artisan migrate
```

9. Run seeders
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

10. Setup Virtual Host
    1. For XAMPP:
         - Go to `C:\WINDOWS\system32\drivers\etc\` and open the `hosts` file in notepad (run as administrator). Add the following line at the end:
            
             ```
             127.0.0.1      portal.test
             ```   

       - Go to `C:\xampp\apache\conf\extra\httpd-vhosts.conf` and add the following code snippet at the end of the file:
        Copy the absolute file path for the `public` directory of the project and paste it below where `your_project_path` is written. For example, your project path may look like `C:/xampp/htdocs/portal/public`.

            ```
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
