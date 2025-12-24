# Standard Operating Procedure: Creating External Users via Command Line

## Overview

This SOP provides step-by-step instructions for System Administrators to create user accounts for external users (users who do not have GSuite email addresses) using PHP Artisan Tinker. This is necessary because the standard UI only supports user creation through GSuite authentication.

## Prerequisites

- System Administrator access to the server/application
- SSH access to the application server
- Access to the application's root directory
- Understanding of the application's roles and permissions system

## Required Information

Before creating a user, gather the following information:

1. **User's Full Name** - The display name for the user
2. **User's Email Address** - Must be a valid, unique email address
3. **User's Password** - A secure password (minimum 6 characters recommended)
4. **User's Role(s)** - One or more roles to assign (see Available Roles section)

## Available Roles

The following roles are available in the system:

- `super-admin` - Super Admin (full system access)
- `admin` - Admin (all permissions except adding new Admin)
- `employee` - Employee (basic employee actions)
- `hr-manager` - HR Manager (HR responsibilities)
- `finance-manager` - Finance Manager (finance management)
- `intern` - Intern (training role)
- `contractor` - Contractor (contract-based personnel)
- `support-staff` - Support Staff (non-billing support team)

**Note:** For external users, typical roles would be `contractor`, `support-staff`, or custom roles as per business requirements. Avoid assigning `super-admin` or `admin` roles to external users unless explicitly required.

## Step-by-Step Instructions

### Step 1: Access the Application Directory

Navigate to the application's root directory:

```bash
cd /path/to/application
```

### Step 2: Launch PHP Artisan Tinker

Start the Tinker console:

```bash
php artisan tinker
```

You should see a prompt that looks like:
```
Psy Shell v0.x.x (PHP 8.x.x — cli) by Justin Hileman
>>>
```

### Step 3: Import Required Classes

Import the necessary classes:

```php
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
```

### Step 4: Verify Email Uniqueness (Optional but Recommended)

Check if the email already exists:

```php
$existingUser = User::where('email', 'user@example.com')->first();
if ($existingUser) {
    echo "User with this email already exists!\n";
} else {
    echo "Email is available.\n";
}
```

Replace `user@example.com` with the actual email address.

### Step 5: Create the User

Create a new user with the following command structure:

```php
$user = User::create([
    'name' => 'John Doe',
    'email' => 'john.doe@external-company.com',
    'password' => Hash::make('SecurePassword123!'),
    'provider' => 'default',
    'provider_id' => 'external-' . time(),
    'avatar' => null
]);
```

**Important Notes:**
- Replace `'John Doe'` with the user's actual full name
- Replace `'john.doe@external-company.com'` with the user's actual email
- Replace `'SecurePassword123!'` with the user's desired password (will be hashed automatically)
- The `provider` field is set to `'default'` to distinguish from GSuite users (which use `'google'`)
- The `provider_id` should be unique; using `'external-' . time()` ensures uniqueness
- `avatar` can be set to `null` or a URL if available

### Step 6: Verify User Creation

Confirm the user was created successfully:

```php
echo "User created with ID: " . $user->id . "\n";
echo "Email: " . $user->email . "\n";
echo "Name: " . $user->name . "\n";
```

### Step 7: Assign Role(s) to the User

Assign one or more roles to the user. You can use either role names or role IDs.

#### Option A: Assign by Role Name (Recommended)

```php
$user->assignRole('contractor');
```

To assign multiple roles:

```php
$user->assignRole('contractor', 'support-staff');
```

#### Option B: Assign by Role ID

First, find the role ID:

```php
$role = Role::where('name', 'contractor')->first();
echo "Role ID: " . $role->id . "\n";
```

Then assign:

```php
$user->assignRole($role->id);
```

#### Option C: Sync Roles (Replace All Existing Roles)

If you need to replace all existing roles with new ones:

```php
$user->syncRoles(['contractor']);
```

### Step 8: Verify Role Assignment

Confirm the roles were assigned correctly:

```php
echo "User roles: " . $user->getRoleNames()->implode(', ') . "\n";
```

Or to see detailed role information:

```php
$user->load('roles');
foreach ($user->roles as $role) {
    echo "Role: " . $role->name . " (ID: " . $role->id . ")\n";
}
```

### Step 9: Exit Tinker

Exit the Tinker console:

```php
exit
```

Or press `Ctrl + D` (or `Cmd + D` on Mac).

## Complete Example

Here's a complete example that creates a user and assigns a role in one session:

```php
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

// Check if user exists
$email = 'external.user@example.com';
$existingUser = User::where('email', $email)->first();
if ($existingUser) {
    echo "ERROR: User with email {$email} already exists!\n";
    exit;
}

// Create the user
$user = User::create([
    'name' => 'External User Name',
    'email' => $email,
    'password' => Hash::make('TemporaryPassword123!'),
    'provider' => 'default',
    'provider_id' => 'external-' . time(),
    'avatar' => null
]);

echo "User created successfully!\n";
echo "User ID: {$user->id}\n";
echo "Email: {$user->email}\n";

// Assign role
$user->assignRole('contractor');

// Verify role assignment
echo "Assigned roles: " . $user->getRoleNames()->implode(', ') . "\n";

// Exit
exit
```

## Troubleshooting

### Error: "Email already exists"

**Solution:** The email address is already in use. Either:
- Use a different email address
- Check if the user already exists and update their information instead
- If the user was soft-deleted, restore them: `$user->restore()`

### Error: "Role not found"

**Solution:** Verify the role name is correct:
```php
$roles = Role::all();
foreach ($roles as $role) {
    echo $role->name . "\n";
}
```

### User Cannot Login

**Possible Causes:**
1. Password was not hashed correctly - ensure you used `Hash::make()`
2. User was soft-deleted - check with: `User::withTrashed()->where('email', 'user@example.com')->first()`
3. Role permissions issue - verify roles are assigned correctly

**Solution:**
```php
// Check if user exists (including soft-deleted)
$user = User::withTrashed()->where('email', 'user@example.com')->first();

// If soft-deleted, restore
if ($user->trashed()) {
    $user->restore();
}

// Reset password
$user->password = Hash::make('NewPassword123!');
$user->save();
```

### Update Existing User Password

If you need to update a user's password:

```php
$user = User::where('email', 'user@example.com')->first();
$user->password = Hash::make('NewPassword123!');
$user->save();
echo "Password updated successfully!\n";
```

### Update Existing User Roles

To update roles for an existing user:

```php
$user = User::where('email', 'user@example.com')->first();
$user->syncRoles(['contractor', 'support-staff']);
echo "Roles updated: " . $user->getRoleNames()->implode(', ') . "\n";
```

## Security Considerations

1. **Password Security:**
   - Use strong passwords (minimum 8 characters, mix of letters, numbers, and symbols)
   - Never share passwords in plain text
   - Consider using a password generator
   - Inform users to change their password on first login (if password reset functionality is available)

2. **Role Assignment:**
   - Only assign necessary roles to external users
   - Avoid assigning `super-admin` or `admin` roles unless absolutely necessary
   - Review role permissions before assignment

3. **Provider Field:**
   - Always use `'default'` for external users (not `'google'`)
   - This helps distinguish external users from GSuite users in the system

4. **Audit Trail:**
   - Document when and why external users were created
   - Keep records of role assignments
   - Note any special permissions granted

## Post-Creation Checklist

After creating a user, verify:

- [ ] User can be found in the database
- [ ] Email address is correct and unique
- [ ] Password is set (hashed)
- [ ] Role(s) are assigned correctly
- [ ] Provider is set to `'default'` (not `'google'`)
- [ ] User can log in with email/password (test if possible)
- [ ] User has appropriate permissions for their role

## Additional Resources

- **Laravel Permission Documentation:** [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/v3/introduction)
- **Laravel Tinker Documentation:** [Laravel Tinker](https://laravel.com/docs/artisan#tinker)
- **Application Authorization Docs:** See `docs/authorization.md` in this repository

## Support

If you encounter issues not covered in this SOP:

1. Check the application logs: `storage/logs/laravel.log`
2. Review the User model: `Modules/User/Entities/User.php`
3. Consult with the development team
4. Review role and permission configurations in the database

---

**Document Version:** 1.0  
**Last Updated:** [Current Date]  
**Maintained By:** System Administration Team

