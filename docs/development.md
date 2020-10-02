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
