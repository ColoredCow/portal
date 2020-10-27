## Testing Guidelines :mag_right:
Testing is a critical and required part of the ColoredCow-Portal.

### UAT account setup
1. Create the `SSH`(RSA) Key Pair

The first step is to create the key pair on the client machine (there is a good chance that this will just be your computer):
```
ssh-keygen -t rsa
```
2. Store the Keys and Passphrase

Once you have entered the Gen Key command, you will get a few more questions:
```
Enter file in which to save the key (/home/demo/.ssh/id_rsa):
```
You can press enter here, saving the file to the user home (in this case, my example user is called demo).
```
Enter passphrase (empty for no passphrase):
```
It’s up to you whether you want to use a passphrase. Entering a passphrase does have its benefits: the security of a key, no matter how encrypted, still depends on the fact that it is not visible to anyone else.

The `Public key` is now located in ```/home/demo/.ssh/id_rsa.pub```. The `Private key`(identification) is now located in ```/home/demo/.ssh/id_rsa```.

3. Contact UAT administrator

Once you have the `Public key`, Please contact the UAT administrator with this public to gain access to UAT.

### Working in UAT
1. Change the directory to where `Private key` is located in your local machine.
```
cd /home/demo/.ssh/id_rsa
```
2. Login to server
```
ssh -i id_rsa your-name@uat.employee.coloredcow.com
```
In this case, the `Private key` name is ```id_rsa```. There may be a chance your key name may look like ```my_private_key_file.pem```.

3. Change directory to project directory
```
cd /var/www/html/uat.employee.coloredcow/
```
4. You will see the project directory. Run required commands like git pull, npm, composer etc to update the portal and submodules.