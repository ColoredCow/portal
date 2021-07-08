## Deployment Guidelines :mag_right:
Deployment is a critical and required part of the ColoredCow-Portal.

### UAT account setup
1. Create the `SSH`(RSA) Key Pair

Create the key pair on your machine by running the following command.
```sh
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
```sh
cd /home/username/.ssh/id_rsa
```
In case of window machine change directory to
```sh
cd C:\Users\username\.ssh\id_rsa
```
2. Login to the server
```sh
ssh -i id_rsa your-name@uat.employee.coloredcow.com
```
In this case, the `Private key` name is ```id_rsa```. There may be a chance your key name may look like ```my_private_key_file.pem```.

3. Once successfully logged in, change directory to project directory
```sh
cd /var/www/html/uat.employee.coloredcow/
```
1. You will see the project directory. Run required deployment commands to update the portal.

#### Deployment Commands - UAT

```sh
git pull origin master
npm install
composer install
php artisan migrate
cp .env.example .env
npm run production
```

#### Deployment Commands - Production
Production builds happen when new releases are published. For example `v1.1.2`.
```sh
git pull origin master
npm install
composer install
php artisan migrate
cp .env.example .env
npm run production
```

#### Remembering git password
In case, git asks you to enter username and password for every module pull, you can cache your credentials in cache. Run the following command and run the deployment commands above.
```
git config --global credential.helper cache
```

After this, it will only ask you to enter your GitHub password once and will cache password for the next 15 min.

**Precaution**: Please use [GitHub access tokens](https://docs.github.com/en/free-pro-team@latest/github/authenticating-to-github/creating-a-personal-access-token) instead of raw passwords. These are more secure and not easy to guess.
