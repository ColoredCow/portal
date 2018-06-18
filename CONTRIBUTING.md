# Contributing

When contributing to this repository, please first discuss the change you wish to make via an issue before making a change.

1.Before contributing keep this thing in your mind that sychronize your develop from base.
        
        $ git pull  base develop
        

2.For every issue or contributing in repository create a new branch  for this.

        $ git branch branch name
        -branch name should be something like this  < 221_create_new_column> ,221 is issue no.

3.Try to frequently commit the changes.
        
        $ git commit -m <"appropriate message">
     
4.After commit push your commits to the the origin. 
    -For push    
        
        $ git push --set-upstream origin branch name 
        -it will push the contents from local feature branch to remote feature branch.

  
5.It's your responsibility to **self review and self test** your commits because it may conflict with base and cause errors.

6.Always  done your pull request(PR) to the base  from your origin and for this repository base is **coloredcow/employee-portal**.

7.After pull request write a  **description about your issue and what you have done in the code.**

8.Atlast please leave a *feedback* and request for *review* the code.


### Some key points
1.Laravel follows the [PSR-2](https://www.php-fig.org/psr/psr-2/) coding standard and the [PSR-4](https://www.php-fig.org/psr/psr-4/) autoloading standard.

2.[StyleCI](https://styleci.io/) provides checks for both your open and closed source repositories. By analyzing every push or pull request made on your codebase, StyleCI ensures that your code is always written against the standards you want it to be.

3.Unit testing for feature , for more imformation [Testing](https://laravel.com/docs/5.6/testing) 

4.Avoid the bug reports. **"Bug Reports"** may also be sent in the form of a pull request containing a failing test.




