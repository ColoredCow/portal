## Development Guidelines :computer:
1. Make sure you have added yourself as an assignee to the GitHub issue you are working on. In case there is no GitHub issue, please create one or ask the admin to create an issue.
2. Use the installation guidelines to set up the project.


## Working in the `portal` repo
1. Pulling with submodules

    * Once you have set up the submodules you can update the repository with fetch/pull like you would normally do. To pull everything including the submodules, use the ```--recurse-submodules``` and the ```--remote``` parameter in the git pull command.

        ```sh
        cd project/
        git checkout develop           # switch to develop branch
        git pull --recurse-submodules  # pull all changes in the repo including changes in the submodules
        git submodule update --remote  # pull all changes for the submodules
        ```

2. Push your local changes to Github.
    * Once you have updated the develop branch with the latest changes, you can follow these steps to create Pull Request.  

        ```sh
        git checkout -b branchname     # create a branch where you will commit your changes
        git add .                      # stage the changes
        git commit -m 'message'        # commit the changes
        git push origin branchname     # push your local branch to GitHub and then create a Pull Request
        ```

## Working in a `submodule` repo

1. Updating the submodules with lastest changes
    * However, you can use these commands to pull updates from the latest develop on submodule individually.

        ```sh
        cd project/Modules/MODULENAME
        git checkout develop            # switch to develop branch
        git pull origin develop         # pull updates from latest develop
        ```
2. Push your local changes to Github
    *  Once you have updated the develop branch with the latest changes, you can follow these steps to create Pull Request on submodule repo.

        ```sh
        git checkout -b branchname     # create a branch where you will commit your changes
        git add .                      # stage the changes
        git commit -m 'message'        # commit the changes
        git push origin branchname     # push your local branch to GitHub submodule repo and then create a Pull Request
        ```
## Submodule Tips

There are a few things you can do to make working with submodules a little easier.

1. Submodule Foreach

    * Git provides a command that lets us execute an arbitrary shell command on every submodule. For our example we assume that we want to checkout develop branch in all submodules.

        ```sh
        git submodule foreach 'git checkout develop'   # checkout develop branch in all submodules
        ```

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
    1. [PSR-2 coding standard](https://www.php-fig.org/psr/psr-2/).

### References
1. [Laravel Guidelines](https://github.com/ColoredCow/resources/tree/master/laravel)
