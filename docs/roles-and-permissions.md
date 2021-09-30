## Roles and Permissions

# Naming Convention
5 basic operations - viewAny, view, create, update, delete
and permissions will be like module.model.operation

For Example:
For a database model Employee we will have permissions

1. hr.university.viewAny
2. hr.university.view
3. hr.university.create
4. hr.university.update
5. hr.university.delete

Every model must have at least these permission defined. The author must create seeders for any new model permissions.

Permissions should be check at two places.

1. Controller policies
2. Blade views

Roles should not be check in the code.
