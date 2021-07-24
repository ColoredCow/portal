## Development Guidelines :computer:
1. Make sure you have added yourself as an assignee to the GitHub issue you are working on. In case there is no GitHub issue, please create one or ask the admin to create an issue.
2. Use our [installation guidelines](./installation.md) to set up the project.


## Working in the `portal` repo
1. Push your local changes to Github.
    * Once you have updated you master branch with the latest changes, you can follow these steps to create a new branch, make changes, and push it to GitHub.

        ```sh
        git checkout -b branchname     # create a branch where you will commit your changes
        git add .                      # stage the changes
        git commit -m 'commit message'        # commit the changes
        git push origin branchname     # push your local branch to GitHub and then create a Pull Request
        ```

**Note: For creating migrations and seeders**

When you are working in specified module, create migrations/seeders in the specified module instead of the main portal module.

## Coding Guidelines and Conventions

1. Naming Conventions
    1. [Controllers](https://www.laravelbestpractices.com/#controllers)
    2. [Models](https://www.laravelbestpractices.com/#models)
    3. [Functions](https://www.laravelbestpractices.com/#functions)
    4. [Routes](https://www.laravelbestpractices.com/#routes)
    5. [Variables](https://www.laravelbestpractices.com/#variables)
    6. [Views](https://www.laravelbestpractices.com/#variables)

2. Database conventions
    1. [Table and Fields Naming](https://www.laravelbestpractices.com/#table-fields-naming)
    2. [Database Alterations](https://www.laravelbestpractices.com/#database-alterations)

3. Formatting
    1. [PSR-2 coding standard](https://www.php-fig.org/psr/psr-2/)

### References
1. [Laravel Guidelines](https://github.com/ColoredCow/resources/tree/master/laravel)
2. [Laravel Modules](https://nwidart.com/laravel-modules/v6/introduction)
