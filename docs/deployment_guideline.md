## Deployment Guidelines :mag_right:
Deployment is a critical and required part of the ColoredCow-Portal.

### UAT account setup
1. Create the `SSH`(RSA) Key Pair

Create the key pair on your machine by running the following command.
```
ssh-keygen -t rsa
```
2. Store the Keys and Passphrase

Follow the steps/questions mentioned below. 
```
Enter file in which to save the key (/home/username/.ssh/id_rsa):
```
Press enter to save the file.
```
Enter passphrase (empty for no passphrase):
```
Entering a passphrase adds one more level of security, it’s up to you whether you want to use a passphrase.

The `Public key` is now located in ```/home/username/.ssh/id_rsa.pub```. The `Private key`(identification) is now located in ```/home/username/.ssh/id_rsa```.

In case of window machine keys are located in ```C:\Users\username\.ssh```

3. Contact UAT administrator

Once you have the `Public key`, please contact the UAT administrator with this public key to gain access to UAT.

### Accessing UAT through SSH
1. Change the directory to where `Private key` is located in your local machine.
```
cd /home/username/.ssh/id_rsa
```
2. Login to the server
```
ssh -i id_rsa your-name@uat.employee.coloredcow.com
```
In this case, the `Private key` name is ```id_rsa```. There may be a chance your key name may look like ```my_private_key_file.pem```.

3. Once successfully logged in, change directory to project directory
```
cd /var/www/html/uat.employee.coloredcow/
```
4. You will see the project directory. Run required deployments commands to update the portal and submodules.

#### Deployments Commands

```sh
git checkout develop                              # switch to develop branch
git submodule update --init                       # updates all the submodules
git submodule update --init Modules/MODULENAME    # update submodule individually
git pull origin master                            # pull updates from latest master
git pull --recurse-submodules                     # pull all changes in the portal and submodules
git submodule update --remote                     # pull all changes for the submodules
git submodule foreach 'git checkout master'       # executing a command on every submodule
npm install                                       # install dependencies
composer install                                  # install dependencies
npm run production                                # Run all Mix tasks and minify output...
```