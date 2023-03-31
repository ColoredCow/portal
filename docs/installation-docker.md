#INSTALLATION GUIDELINES

Before you start following the guidelines, make sure to go through the prerequisites guide to install the Docker and docker-compose on your computer or download Docker Desktop.

If you are in the right directory where you want your portal to be saved locally, follow the below steps:

1. Clone this repository and move to `portal` directory
   ```sh
   git clone https://github.com/coloredcow/portal
   cd portal
   ```

2. Make a copy of the `.env.example` file in the same directory and save it as `.env`:
   ```sh
   cp .env.example .env	
   ```
3. Create a directory named `mysql` in the root folder `portal`
   ```sh
   mkdir mysql
   ```
4. Add the following settings in `.env` file:
    1. Laravel app configurations
    ```sh
    APP_NAME="ColoredCow Portal"
    APP_ENV=local
    APP_DEBUG=true
    APP_URL=http://portal.test
    
    LOG_CHANNEL=stack
    WWWGROUP=1000
    WWWUSER=1000
    ```

    2. Database configurations

    ```sh
    DB_CONNECTION=mysql
    DB_HOST=portal-mysql-1
    DB_PORT=3306
    DB_DATABASE=portal1
    DB_USERNAME=sail
    DB_PASSWORD=password
    MYSQL_DOCKER_FOLDER=./mysql
    ```
	
5. Build the dockerfile and start the containers using:
   	```sh
   	docker-compose up -d --build
   	```
  
6. Check if your containers are running:
   	```sh
   	docker ps
   	```
   It should give you 3 containers started/running
  	 
7. Now copy the container-id of `portal_laravel.test1`,
   Go to terminal and type
	```sh
 	docker exec -it <container_id that you copied> bash
   	```   
8. Now you are inside the /var/www/html i.e inside your container environment,
     Install dependencies
   ```sh
   composer install
   npm install
   ```

9. npm build
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

10. Run the following command to add the Laravel application key:
    ```sh
    php artisan key:generate
    ```

11. Run migrations
    ```sh
    php artisan migrate
    ```

12. Run seeders
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

13. Exit from the bash shell of laravel container
    ```sh
    exit
    ```
14. Next, open this url in your browser: http://portal.test
15. Login to the portal using the newly created user in the database. Go to `http://localhost:8080/index.php` and search for the `users` table and you can find the user email in it (user@coloredcow.com). The default password to log in is `12345678`.

16. To stop the containers
    ```sh
    docker-compose down
    ```

**Note** :  To start containers, you do not need to build image everytime.
    You can use the below command.
    ```sh
    docker-compose up -d
    ```

