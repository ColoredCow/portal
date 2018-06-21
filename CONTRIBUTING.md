# Contribution guidelines

When contributing to this repository, please first discuss the change you wish to make via an issue before making a change.

1. Fork this repository. Read about [how to fork a repository](https://help.github.com/articles/fork-a-repo/).

2. For every contribution, create a new branch. A branch name must follow the format `issueID-issue-info`.

        > git branch 497-billing-calculation

3. Make brief and clear commit messages.
        
        > git commit -m "fixed the user interface for application listing"
  
3. Once the development is complete, create a pull request from your forked repository to `coloredcow:develop`.

4. While creating the pull request, put a clean and short description of the functionality changes you have done.

5. Make sure there are no conflicts in the pull request. Before creating a PR, make sure you **perform a self-review and do a detailed testing** of the functionality you built.

6. Make sure the [TravisCI](https://travis-ci.org/ColoredCow/employee-portal/builds) and [StyleCI](https://github.styleci.io/repos/125008594) builds are passing. Any failing PRs won't get accepted.

7. When a reviewer leaves the review feedback, make sure you communicate clearly on those points. Comment your doubts/opinions on the discussion thread.

8. Once you complete the feedback, comment and mention the reviewer to perform a code review again.
