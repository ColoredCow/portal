## Authorization :key:
Associate users with roles and permissions to get started.

1. Create a new account in employee-portal. Please ignore this step if already created an account.

2. Assigning roles to the users
    1. Run the following command to boot up tinker
    ```
    php artisan tinker
    ```
    2. Using namespace
    ```
    use Modules\User\Entities\User
    ```
    3. Extract the User from the database.
    ```
    $user=User::first()
    ```
    4. Assign roles to the user
    ```
    $user->assignRole('super-admin')
    ```
### Reference
[Laravel-permission](https://spatie.be/docs/laravel-permission/v3/introduction) 