## Branch Naming Guidelines
In any software development company, every day many branches are created and pushed to the github repository. So, having a manageable code repository is mandatory when working on a team project.
Therefore, ColoredCow uses a branch naming conventions to work with git repositories. 

In this convention the branches are divided into two categories:

### Code Flow Branches 
These branches which we expect to be permanently available on the repository follow the flow of code changes starting from development until the production.

 #### 1. Development
All new features and bug fixes should be pushed to the development branch. Resolving developer codes conflicts should be done as early as here.

#### 2. Master
The production branch, if the repository is published, this is the default branch being presented.
    
### Temporary Branches-  
As the name implies, these are disposable branches that can be created and deleted by need of the developer or deployer.
#### 1. Feature
Any code changes for a new module or use case should be done on a feature branch. This branch is created based on the current development branch. When all changes are Done, a Pull Request/Merge Request is needed to put all of these to the development branch.
		
	Examples:
		feature/issue-21
		feature/issue-30_dark-theme

It is recommended to use all lower caps letters and hyphen (-) to separate words unless it is a specific item name or ID. Underscore (_) could be used to separate the ID and description.

#### 2. Bug Fix
If the code changes made from the feature branch were rejected after a release, sprint or demo, any necessary fixes after that should be done on the bugfix branch.
		
	Examples:
		bugfix/change-color
		bugfix/issue-21_mail-not-sending

#### 3. Hot Fix
If there is a need to fix a blocker, do a temporary patch, apply a critical framework or configuration change that should be handled immediately, it should be created as a Hotfix. 
		
	Examples:
		hotfix/disable-endpoint-zero-day-exploit
		hotfix/increase-scaling-threshold

#### 4. Experimental
Any new feature or idea that is not part of a release or a sprint. A branch for playing around.

	Examples:    	
		experimental/dark-theme-support

#### 5. Release
A branch for tagging a specific release version.

	Examples:    	
		release/coloredcowapp-1.01.123

#### 6.Merging
A temporary branch for resolving merge conflicts, usually between the latest development and a feature or Hotfix branch. This can also be used if two branches of a feature being worked on by multiple developers need to be merged, verified and finalized.

	Examples:
		merge/dev_lombok-refactoring
		merge/combined-device-support

