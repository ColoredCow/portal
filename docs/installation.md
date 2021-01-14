## Installation Guidelines :rocket:

1. Clone this repository
```sh
git clone https://github.com/coloredcow-portal/portal
```
2. Clone the submodules

Clone every submodule individually

```sh
cd portal
git submodule update --init Modules/MODULENAME
```
3. Checkout develop branch
```sh
git submodule foreach 'git checkout develop'
```

4. Install dependencies
```sh
composer install
npm install
```

5. npm build
```sh
npm run dev
```

6. Install the submodules:
```sh
php artisan portal:setup
```
However, you may use the ```module``` option to specify a specific ```MODULENAME``` to install individually:

```sh
php artisan portal:setup --module=MODULENAME
```

7. Copy `.env.example` as `.env`

8. Run the following command to add a key
```
php artisan key:generate
```
9. Add the following settings in `.env` file:
    1. Laravel app configurations
    ```
    APP_NAME, APP_ENV, APP_DEBUG, APP_URL
    ```

    2. Database configurations        
        
        Make sure you have a database ctreated in your local server.
        For more info check this [link](https://www.youtube.com/watch?v=4geOENi3--M)
        
    ```
    DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
    ```
    
    
    3. Google configurations
    ```
    GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, GOOGLE_CLIENT_CALLBACK, GOOGLE_CLIENT_HD, GOOGLE_API_KEY, GOOGLE_APPLICATION_CREDENTIALS, GOOGLE_SERVICE_ACCOUNT_IMPERSONATE
    ```

10. Run migrations
```
php artisan migrate
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
