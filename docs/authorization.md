## Authorization :key:
Associate users with roles and permissions to get started.

1. Create a new account in the portal. Please ignore this step if already created an account.

2. Assigning roles to the users
    1. Run the following command to boot up tinker in the terminal/CMD in your project directory.
    ```
    php artisan tinker
    ```
    2. Once you are in, use the following namespace
    ```
    use Modules\User\Entities\User
    ```
    3. Extract the User from the database.
    ```
    $user = User::first()
    ```
    4. Assign the super-admin role to the user, however you can change the roles available in the system as per requirements.
    ```
    $user->assignRole('super-admin')
    ```
### Reference
[Laravel-permission](https://spatie.be/docs/laravel-permission/v3/introduction) 