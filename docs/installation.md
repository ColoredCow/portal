## Installation Guidelines :rocket:

1. Clone this repository
```sh
git clone https://github.com/coloredcow-portal/portal
```

2. Copy `.env.example` as `.env`

3. Run the following command to add a key
```
php artisan key:generate
```
4. Add the following settings in `.env` file:
    1. Laravel app configurations
    ```
    APP_NAME, APP_ENV, APP_DEBUG, APP_URL
    ```

    2. Database configurations
    ```
    DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
    ```

    3. Google configurations
    ```
    GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, GOOGLE_CLIENT_CALLBACK, GOOGLE_CLIENT_HD, GOOGLE_API_KEY, GOOGLE_APPLICATION_CREDENTIALS, GOOGLE_SERVICE_ACCOUNT_IMPERSONATE
    ```

5. Install the submodules:
```sh
git submodule update --init
```

6. Install dependencies
```sh
composer install
npm install
```

7. npm build
```sh
npm run development
```

8. Install dependencies for each module
```sh
cd Modules/MODULENAME
composer install
npm install
```

9. npm build for each module
```sh
cd Modules/MODULENAME
npm run development
```  

10. Run migrations
    1. Portal
    ```
    php artisan migrate
    ```
    
    2. Submodule

    Migrate the given module, or without a module an argument, migrate all modules.
    ```
    php artisan module:migrate MODULENAME
    ```

11. Run seeders
    1. Portal
    ```
    php artisan db:seed
    ```
    However, you may use the ```--class``` option to specify a specific seeder class to run individually:
    ```
    php artisan db:seed --class=CLASSNAME
    ```
    2. Submodule

    Seed the given module, or without an argument, seed all modules
    ```
    php artisan module:seed MODULENAME
    ```