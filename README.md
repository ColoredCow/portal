# Welcome to ColoredCow's Employee Portal

Solution for organizations to manage all operations' data. Built over GSuite.

### Status

[![Travis](https://img.shields.io/travis/ColoredCow/employee-portal.svg?style=for-the-badge)](https://travis-ci.org/ColoredCow/employee-portal)


### Installation
1. Clone or download the repository
```
git clone https://github.com/coloredcow/employee-portal
```

2. Install dependencies:
```
composer install
npm install
```

3. Copy `.env.example` as `.env`

4. Run the following command to add a key
```
php artisan key:generate
```
5. Add the following settings in `.env` file:
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

6. Run migrations
```
php artisan migrate
```
