## Deployment Guidelines :mag_right:
Portal uses GitHub action to deploy the portal on staging server.

### Staging Deployment
Staging builds are configured using GitHub Actions. The file `.github/workflows/deploy-staging.yml` contains the commands to deploy the portal. Production builds happen when code is pushed to `master` branch.

To set up the deployment workflow, follow the steps below.

1. Generate an SSH key pair.
    ```sh
    ssh-keygen -f `staging.pem`
    ```
2. It will ask you the passphrase. Keep it empty.
3. Once the keys are created, update the key permissions.
    ```sh
    chmod 400 staging.pem
    ```
4. Use the commands below to get the `Public key` and `Private key` content. These values will be used later.
    ```sh
    ssh-keygen -y -f staging.pem  # to get the public key content
    vi staging.pem  # to get the private key content
    ```
5. Log in to the staging server as the root user.
6. Make a new user using the following commands (works for Ubuntu/Debian):
    ```sh
    # sudo
    sudo su

    # add user named `githubaction` without password
    adduser githubaction --disabled-password

    # create .ssh directory for the user
    mkdir -p /home/githubaction/.ssh

    # create authorized_keys and enter the public key content for the user
    vim /home/githubaction/.ssh/authorized_keys

    # grant all permissions to user
    chown -R githubaction:githubaction .ssh/
    ```
7. Go to GitHub repo settings and switch to environment tab.
8. Create a new environment named `staging`.
9.  Add the following environment variables within that environment:
   1.  `SSH_HOST`: The IP of the staging server.
   2.  `SSH_USERNAME`: The username of the staging server. If you have followed the user creation steps above, it would be `githubaction`.
   3.  `SSH_PRIVATE_KEY`: Paste the private key content from step 4.
   4.  `SSH_BUILD_DIRECTORY`: The directory where the project is located.

For more information, check out [staging-deployment.yml](../.github/workflows/staging-deployment.yml).

### Production Deployment
Production builds are configured using GitHub Actions. The file `.github/workflows/deploy-staging.yml` contains the commands to deploy the portal. Production builds happen when new releases are published. For example `v1.1.2`.

To set up the production deployment workflow, follow the same steps as staging. Make sure to update the keys and environment variables accordingly.

For more information, check out [production-deployment.yml](../.github/workflows/production-deployment.yml).
