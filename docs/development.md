## Development Guidelines :computer:
1. Make sure you have added yourself as an assignee to the GitHub issue you are working on. In case there is no GitHub issue, please create one or ask the admin to create an issue.
2. Use the installation guidelines to set up the project.


## Working in the `portal` repo
```sh
cd project/
git checkout master            # switch to master branch
git pull origin master         # pull updates from latest master
git submodule update --init    # updates all the submodules
git checkout -b branchname     # create a branch where you will commit your changes
git add .                      # stage the changes
git commit -m 'message'        # commit the changes
git push origin branchname     # push your local branch to GitHub and then create a Pull Request
```

## Working in a `submodule` repo
```sh
cd project/Modules/MODULENAME
git checkout master            # switch to master branch
git pull origin master         # pull updates from latest master
git checkout -b branchname     # create a branch where you will commit your changes
git add .                      # stage the changes
git commit -m 'message'        # commit the changes
git push origin branchname     # push your local branch to GitHub submodule repo and then create a Pull Request
```
## Coding style

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
    1. We at Portal follows the PSR-2 coding standard.
