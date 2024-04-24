## Installation Guidelines :rocket:

Before you start following the guidelines, make sure to go through the [prerequisites guide](./prerequisites.md) to install the required tools and packages on your machine.

**Note:** If you are a Windows user, use GitBash or PowerShell instead of the command prompt.

1. Navigate to the right directory where your project will be locally saved
    - For WAMP:
        ```sh
        cd C:\wamp64\www\
        ```
    - For XAMPP:
        ```sh
        cd C:\xampp\htdocs\
        ```
    - For LAMPP:
        ```sh
        cd C:\opt\htdocs\
        ```
    - For MAMP(macOS):
        ```sh
        cd /Application/MAMP/htdocs/
    ```
    Note- phpMyAdmin/PHP, apache, and MySQL comes preinstalled with the  WAMP, XAMPP package, that is going to be used later on in this project, so no need to install these files separately. 

2. Clone this repository and move to `portal` directory
   ```sh
   git clone https://github.com/coloredcow/portal
   cd portal
   ```

3. Install dependencies
   ```sh
   composer install
   npm install
   ```

4. npm build
   ```sh
   npm run dev
   ```
    A possible error may arise with `cross-env`. So try running the following commands.
    - To clear a cache in npm, we need to run the npm cache command in our terminal and install cross-env.
   ```sh
   npm cache clear --force
   npm install cross-env

   npm install
   npm run dev
   ```
    If you are still getting the error --hide-module then revert all changes by `git checkout .`

   If you are still getting the error then delete the `package-lock.json` file and make sure your node and npm version are as below and repeat step 4 again.
    ```sh
    npm -v
    # output should be something like
    # 9.5.1

    node -v
    #output should be somthing like
    #v18.16.0
    ```


5. Make a copy of the `.env.example` file in the same directory and save it as `.env`:
    ```sh
    cp .env.example .env
    ```

6. Run the following command to add the Laravel application key:
   ```sh
   php artisan key:generate
   ```
   **Note:** Make sure that the 'php.ini' file in XAMPP/WAMP has this code uncommented/written
    `extension=gd`


7. Add the following settings in `.env` file:

    1. Laravel app configurations
    ```sh
    APP_NAME="ColoredCow Portal"
    APP_ENV=local
    APP_DEBUG=true
    APP_URL=http://portal.test
    ```

    2. Database configurations
    - Create a database in your local server. If you skipped it on the prerequisites guideline, you can check it out on point 3.4 of the prerequisites. [Go to prerequisites](https://github.com/ColoredCow/portal/blob/master/docs/prerequisites.md)
    - Configure your Laravel app with the right DB settings as mentioned below.
    - Read [the story](https://docs.google.com/document/d/1sWj0F2uXkSE9oHBkChv-yC2L7P7qazsPY5sNPC1PIp4/edit) about how the team discussed which video should be in the docs
    ```sh
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=portal
    DB_USERNAME=root
    DB_PASSWORD=
    ```
    **Note:** Use the default values for MySQL database in `.env` file

    ```sh
    DB_USERNAME=root
    DB_PASSWORD=
    ```

    These credentials will be used when you will connect to MySQL Server whether you use XAMPP, WAMP, MAMP (PhpMyadmin) or TablePlus, the proper steps you can find here in the [prerequisites guide](./docs/prerequisites.md).

    3. _(Optional)_ Google configurations.
    ```sh
    GOOGLE_CLIENT_ID=
    GOOGLE_CLIENT_SECRET=
    GOOGLE_CLIENT_CALLBACK=
    GOOGLE_CLIENT_HD=
    GOOGLE_API_KEY=
    GOOGLE_APPLICATION_CREDENTIALS=
    GOOGLE_SERVICE_ACCOUNT_IMPERSONATE=
    ```

    4. _(Optional)_ ColoredCow website Configurations
    In case you want to use website integration functionality, then you need to enable `WORDPRESS_ENABLED` as `true` and add wordpress database configurations.

       - DB_WORDPRESS_DATABASE: The name of the WordPress database you want to connect to. For example `Coloredcow`.
       - DB_WORDPRESS_USERNAME: The user name which is define in the Wp-config.php. For example `root`.
       - DB_WORDPRESS_PASSWORD: If password is define set the password otherwise it should be null.
       - DB_WORDPRESS_PREFIX: The table prefix used by the WordPress installation. This is typically set to `cc_` by default, but it can be different depending on the configuration. 
       - WORDPRESS_ENABLED: Set this to `true` to enable the integration with the ColoredCow website. If it is set to `false` the integration will not work.

    ```sh
    DB_WORDPRESS_DATABASE=Coloredcow
    DB_WORDPRESS_USERNAME=root
    DB_WORDPRESS_PASSWORD=
    DB_WORDPRESS_PREFIX=cc_
    WORDPRESS_ENABLED=true
    ```
   


8. Run migrations
    ```sh
    php artisan migrate
    ```

9. Run seeders
    1. Portal
        ```sh
        php artisan db:seed
        ```
        _(Optional)_ In case you want to run a specific seeder class, use the ```--class``` option:
        ```sh
        php artisan db:seed --class=CLASSNAME
        ```
    2. Module:
        ```sh
        php artisan module:seed
        ```
        _(Optional)_ In case you want to run seeders inside a specific module, run:
        ```sh
        php artisan module:seed MODULE_NAME
        ```

10. Setup Virtual Host
    1. For WAMP:
        - Go to `C:\WINDOWS\system32\drivers\etc\` and open the `hosts` (not the one with ICS extension) file in notepad (run as administrator). Add the following line at the end:
            ```
            127.0.0.1      portal.test
            ```
        - Go to `C:\wamp64\bin\apache\apache2.4.46\conf\extra\httpd-vhosts.conf` and add the following code snippet at the end of the file. Copy the absolute file path for the `public` directory of the project and paste it below where `/path/to/your/project` is written. For example, your project path may look like `C:\wamp64\www\portal\public`.
            ```apacheconf
            <VirtualHost *:80>
                ServerName portal.test
                DocumentRoot "/path/to/your/project"
                <Directory "/path/to/your/project">
                    DirectoryIndex index.php
                    AllowOverride All
                    Order allow,deny
                    Allow from all
                </Directory>
            </VirtualHost>
            ```
            In case you are using Apache version 2.4 or above, the above code will give you a 403 Forbidden error. Make the following changes:
            ```apacheconf
            <Directory>
                # some code above
                Order allow,deny
                Allow from all
            </Directory>
            ```
            Change to:
            ```apacheconf
            <Directory>
                 # some code above
                 Require all granted
            </Directory>
            ```
        - Restart WAMP. Next, open this url in your browser: http://portal.test

    2. For XAMPP:
        - Go to `C:\WINDOWS\system32\drivers\etc\` and open the `hosts` (not the one with ICS extension) file in notepad (run as administrator) or right click the hosts file, click properties, go to security tab click on edit and give administrator permissions to the file. Add the following line at the end:
            ```
            127.0.0.1      portal.test
            ```

        - Go to `C:\xampp\apache\conf\extra\httpd-vhosts.conf` and add the following code snippet at the end of the file. Copy the absolute file path for the `public` directory of the project and paste it below where `your_project_path` is written. For example, your project path may look like `C:\xampp\htdocs\portal\public`.
            ```apacheconf
            <VirtualHost *:80>
                ServerName portal.test
                DocumentRoot "/path/to/your/project"
                <Directory "/path/to/your/project">
                    DirectoryIndex index.php
                    AllowOverride All
                    Order allow,deny
                    Allow from all
                </Directory>
            </VirtualHost>
            
            In case you are using Apache version 2.4 or above, the above code will give you a 403 Forbidden error. Make the following changes:
            ```apacheconf
            <Directory>
                # some code above
                Order allow,deny
                Allow from all
            </Directory>
            ```
            Change to:
            ```apacheconf
            <Directory>
                 # some code above
                 Require all granted
            </Directory>
            ```
           - Restart XAMPP. Next, open this url in your browser: http://portal.test
        

        - Restart XAMPP. Next, open this url in your browser: http://portal.test

    3. For LAMPP(LINUX):
        - Go to `etc/hosts` file or edit this in the terminal use the following command.
            ```sh
            sudo nano /etc/hosts
            ```
        - Add this line
            ```
            127.0.0.1   portal.test
            ```

        - Go to `httpd.conf` file or edit this file in the terminal itself use this command
            ```sh
            sudo nano /opt/lampp/conf/apache/httpd.conf
            ```
            And search for `vhosts` and uncomment line like this
            ```sh
            # Virtual hosts
            # Include opt/lampp/conf/apache/extra/httpd-vhosts.conf
            ```
            Change above to:
            ```sh
            # Virtual hosts
            Include opt/lampp/conf/apache/extra/httpd-vhosts.conf
            ```
          - Open the `vhost` file in the terminal
            ```sh
            sudo nano /etc/apache2/extra/httpd-vhosts.conf
            ```
            Add the following line at the end of the file:
            Copy the absolute file path for the `public` directory of the project and paste it below where `your_project_path` is written. For example, your project path may look like `/opt/lampp/htdocs/portal/public`. Make sure you type '/public' at the end after your project path.

            ```apacheconf
             <VirtualHost *:80>
                 ServerName portal.test
                 DocumentRoot "/path/to/your/project/public"
                 <Directory "/path/to/your/project/public">
                     DirectoryIndex index.php
                     AllowOverride All
                     Order allow,deny
                     Allow from all
                 </Directory>
             </VirtualHost>
            ```
          - In case you are using Apache version 2.4 or above, the above code will give you a 403 Forbidden error. Make the following changes:
            ```apacheconf
            <Directory>
                # some code above
                Order allow,deny
                Allow from all
            </Directory>
            ```
            Change to:
            ```apacheconf
            <Directory>
                 # some code above
                 Require all granted
            </Directory>
            ```
           - Restart MAMP. Next, open this url in your browser: http://portal.test

    4. For MAMP(macOS):
        - Go to `etc/hosts` file or edit this in the terminal use the following command.
            ```sh
            sudo nano /etc/hosts
            ```
        - Add this line
            ```
            127.0.0.1   portal.test
            ```

        - Go to `httpd.conf` file or edit this file in the terminal itself use this command
            ```sh
            sudo nano /Applications/MAMP/conf/apache/httpd.conf
            ```
            And search for `vhosts` and uncomment line like this
            ```sh
            # Virtual hosts
            # Include Applications/MAMP/conf/apache/extra/httpd-vhosts.conf
            ```
            Change above to:
            ```sh
            # Virtual hosts
            Include Applications/MAMP/conf/apache/extra/httpd-vhosts.conf
            ```
          - Open the `vhost` file in the terminal
            ```sh
            sudo nano /etc/apache2/extra/httpd-vhosts.conf
            ```
            Add the following line at the end of the file:
            Copy the absolute file path for the `public` directory of the project and paste it below where `your_project_path` is written. For example, your project path may look like `/Application/MAMP/htdocs/portal/public`. Make sure you type '/public' at the end after your project path.

            ```apacheconf
             <VirtualHost *:80>
                 ServerName portal.test
                 DocumentRoot "/path/to/your/project/public"
                 <Directory "/path/to/your/project/public">
                     DirectoryIndex index.php
                     AllowOverride All
                     Order allow,deny
                     Allow from all
                 </Directory>
             </VirtualHost>
            ```
          - In case you are using Apache version 2.4 or above, the above code will give you a 403 Forbidden error. Make the following changes:
            ```apacheconf
            <Directory>
                # some code above
                Order allow,deny
                Allow from all
            </Directory>
            ```
            Change to:
            ```apacheconf
            <Directory>
                 # some code above
                 Require all granted
            </Directory>
            ```
           - Restart MAMP. Next, open this url in your browser: http://portal.test
11. Login to the portal using the newly created user in the database. Go to `http://localhost/phpmyadmin/index.php` click on portal database that we created mostly on the left and search for the `users` table, click on `users` table and you can find the first user email in it. The default password to log in is `12345678`.

12. _(Optional)_ Setup Email configuration:  

    1. Open [Mailtrap](https://mailtrap.io/) and signup/login.  

    2. Create an inbox.  

    3. Open inbox setting and choose Laravel 7+ from Integrations.  

    4. Open .env file and add the following  

        ```sh
        MAIL_DRIVER=smtp
        MAIL_HOST=smtp.mailtrap.io
        MAIL_PORT=yourPortNumber
        MAIL_USERNAME=yourMailtrapUsername
        MAIL_PASSWORD=yourMailtrapPassword
        MAIL_ENCRYPTION=tls
        MAIL_FROM_ADDRESS=senderEmailAddress
        MAIL_FROM_NAME="${APP_NAME}"
        ```
13. _(Optional)_ Setup pdf generator tool for automatic invoice creation:

    1. Open site https://wkhtmltopdf.org/downloads.html and download wkhtmltopdf for window and install it
    
    2. Open .env file and add the following
        ```sh
        
        For Windows: 
        PDF_BINARY='C://"Program Files"/wkhtmltopdf/bin/wkhtmltopdf.exe'

        For Mac:
        PDF_BINARY="/usr/local/bin/wkhtmltopdf"

        ```
    3. Run the following command in the terminal
        ```sh
        php artisan optimize
        ```
14. _(Optional)_ Setup API Layer API Key for currency excahange rates:

    1. Open site https://apilayer.com/

    2. Click on "Browse API Marketplace".

    <img src="https://github.com/ColoredCow/portal/assets/112390100/bfa6f50c-a863-4202-9445-6bf6e8a26319" width="400">

    3. Under catogories click on "Currency"

    <img src="https://github.com/ColoredCow/portal/assets/112390100/50b338cc-ed8c-498b-b8ea-e002f451d187" width="200">

    4. Select Currency Data API.

       <img src="https://github.com/ColoredCow/portal/assets/112390100/6d5d3318-ab0c-4c52-8cba-37725798bfa8" width="200">

    6. Select the Free plan.

       <img src="https://github.com/ColoredCow/portal/assets/112390100/e6c2bd61-153d-4260-9fe5-d97700199724" width="200">

    8. Copy your API key and paste it in the `.env` file.
       `CURRENCYLAYER_API_KEY=your api key`

    9. Run the command `php artisan config:cache`
15. _(Optional)_ Setup Google Service Account for syncing effortsheet on local:

    1. Open Google Console https://console.cloud.google.com/

    2. Create a new project by clicking `CREATE PROJECT`.

        <img width="1438" alt="Screenshot 2024-04-09 at 10 20 35 PM" src="https://github.com/ColoredCow/portal/assets/68751333/45c52794-7e55-49ff-bfe0-0ae492747c97">

    3. Give any name to the Project

        <img width="1440" alt="Screenshot 2024-04-09 at 10 21 32 PM" src="https://github.com/ColoredCow/portal/assets/68751333/fabf52d6-03af-4ab9-a67d-6959cc7207eb">

    4. Enable the following APIs and services by clicking the "Enable APIs and Services" button:
        (i) Google Drive API
        (ii) Google Sheets API

    5. The next step is to create credentials. Click on Credentials on the left panel and then Create Credentials.

        <img width="1440" alt="Screenshot 2024-04-09 at 10 26 03 PM" src="https://github.com/ColoredCow/portal/assets/68751333/f44446ab-2a49-49a1-873e-b8441f671b07">

    6. Fill in the following details:
        (i) Service account details
            <img width="1438" alt="Screenshot 2024-04-09 at 10 28 54 PM" src="https://github.com/ColoredCow/portal/assets/68751333/2b1779a6-ac9a-4ca9-952c-5c55e9a85d55">

        (ii) Grant this service account access to the project by selecting a role (Project -> Editor)
            <img width="1440" alt="Screenshot 2024-04-09 at 10 31 08 PM" src="https://github.com/ColoredCow/portal/assets/68751333/20be4c4f-50de-44b0-ab59-0e9b8ef77e0f">

    7. Go back to credentials and click on edit option in service account section.
        <img src="https://github.com/ColoredCow/portal/blob/update_installation/public/images/editServiceAccount.jpeg">
    8. Go to keys and click on add key button and select Create New Key option.
        <img src="https://github.com/ColoredCow/portal/blob/update_installation/public/images/createKey.jpeg">
    9. A JSON file will be downloaded when you create credentials and key, move that JSON file to the `/portal/public/` folder inside the project.

    10. Open the .env file and add the following  

        ```sh
        GOOGLE_CLIENT_ID= #Copy it from the credentials(OAuth 2 Client ID)
        GOOGLE_CLIENT_SECRET= #Copy it from the credentials(Key ID)
        GOOGLE_CLIENT_CALLBACK=
        GOOGLE_CLIENT_HD=
        GOOGLE_API_KEY=
        GOOGLE_APPLICATION_CREDENTIALS=
        GOOGLE_SERVICE_ACCOUNT_IMPERSONATE=
        GOOGLE_SERVICE_ENABLED=true
        GOOGLE_SERVICE_ACCOUNT_JSON_LOCATION= #Copy the path of the downloaded JSON file after moving it to the /portal/public/ folder
        ```
        ``Note`` Add double backward slash ``\\`` while adding the file path because single backward slash is considered as escape sequence

    11. Copy the Email from the Service Accounts details
        <img width="1440" alt="Screenshot 2024-04-09 at 10 59 51 PM" src="https://github.com/ColoredCow/portal/assets/68751333/acde29bc-f46f-4d4f-ab6a-d7b055e414ab">

    12. Add the email by clicking on the share button
        <img width="1440" alt="Screenshot 2024-04-09 at 11 02 35 PM" src="https://github.com/ColoredCow/portal/assets/68751333/89d80c7d-f176-42f8-aed8-5c3696f97d9d">

    13. Run the command php artisan config:cache

    14. Open the ColoredCow portal http://portal.test/login/

    15. Go to CRM->Projects and select any of the projects.

    16. After opening the project click on edit button and enter the Effortsheet URL then, click on Save button.

    17. Go to phpmyadmin, open users table and change the nicknames of users as team member names in effortsheet.