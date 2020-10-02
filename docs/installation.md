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
    1. Laravel app configurations: `APP_NAME, APP_ENV, APP_DEBUG, APP_URL`
    2. Database configurations: `DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD`
    3. Google configurations: `GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, GOOGLE_CLIENT_CALLBACK, GOOGLE_CLIENT_HD, GOOGLE_API_KEY, GOOGLE_APPLICATION_CREDENTIALS, GOOGLE_SERVICE_ACCOUNT_IMPERSONATE`

5. Install the submodules:
```sh
git submodule update --init
```

6. Install dependencies
```sh
composer install
npm install
```

7. Install dependencies for each module
```sh
cd Modules/MODULENAME
composer install
npm install
```

8. Run migrations
```
php artisan migrate
```
