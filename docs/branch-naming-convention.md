## Branch Naming Convention
In any software development company, every day many branches are created and pushed to the github repository. So, having a manageable code repository is mandatory when working on a team project.
Therefore, ColoredCow uses a branch naming conventions to work with git repositories. 

In this convention the branches are divided into two categories:

### Code Flow Branches 
These branches which we expect to be permanently available on the repository follow the flow of code changes starting from development until the production.

 #### 1. Develop
All new pull requests related to features and bug fixes be merged into this branch after review from the assignee. Resolving developer codes conflicts should be done as early as here.

#### 2. Master
This is the main branch for production. Nothing should be directly pushed into this branch except for the hot-fix errors and the develop branch after the complete testing of the issues or bug fixes.
    
### Temporary Branches-  
As the name implies, these are disposable branches that can be created and deleted by need of the developer or deployer.
#### 1. Feature
Any code changes for a new module or use case should be done on a feature branch. This branch is created based on the current development branch. When all changes are Done, a Pull Request/Merge Request is needed to put all of these to the development branch.
		
	Examples:
		feature/issue-21
		feature/issue-30_dark-theme
        feature/issue-30_add-nickname_hr


It is recommended to use all lower caps letters and hyphen (-) to separate words unless it is a specific item name or ID. Underscore (_) could be used to separate the ID and description.
If there are changes that are affecting another repository also then again an Underscore(_) should be used to specify the module or repository the issue belongs to.

#### 2. Bug Fix
If the code changes made from the feature branch were rejected after a release, sprint or demo, any necessary fixes after that should be done on the bugfix branch.
		
	Examples:
		bugfix/change-color
		bugfix/issue-21_mail-not-sending

#### 3. Hot Fix
If there is an issue in the master branch the it needs to be  fixed immediately, then that issue should be created as a Hotfix. The hotfix branch should be pulled from the master branch and can be directly pushed to the master branch. 
		
	Examples:
		hotfix/disable-endpoint-zero-day-exploit
		hotfix/increase-scaling-threshold

#### 4. Doc
If there is a need to create a new readme/documentation file or do some changes to an existing file, then a doc branch should be created.
		
	Examples:
		doc/naming-conventions
		

