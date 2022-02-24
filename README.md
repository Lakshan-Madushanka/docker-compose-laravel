

# DOCKER COMPOSE SETUP FOR LARAVEL
This provides all the services and extensions to develop laravel applications.

## Services
Following services have been configured with respective ports.
- **php (7.4)** - `:9000`
- **nginx** - `:80`
- **mysql (8.0)** - `:3306`
- **redis (7.0)** - `:6379`
- **mailhog** - `:8025` 
- **php** - `:9000`
- **xdebug** 

## Usage

To get started, docker needs to be installed. To check it run the below command in a terminal. 
```
docker -v
```
To install docker follow the instructions on the official site. 
https://docs.docker.com/get-docker/

After docker is installed, put your laravel project in src folder (the test project has been configured you must remove it).

.env file must in the same directory docker-compose.yml exists.

clone the repository and run the below command in the terminal.
```
docker-compose build
```
After build finished services can be started using,
```
docker-compose up
```
*shorten command* 
```
docker-compose up --build app
```
So stop all containers,
```
docker-compose down
```
# Testing
The test project has been configured to make sure everything work fine, 
1). Run composer install command in src directory. 
2). open a web browser, and enter the link  http://localhost:821/docker-testyou will get the below results.
```
Mysql connection status : succeeded !  
----------
MailHog connection status : succeeded !  
----------
Redis connection status : succeeded !
```
- Alternatively, you can check health status using the below docker command.
```
docker ps
```
![Capture](https://user-images.githubusercontent.com/47297673/155564063-6c9e02c9-4ae7-42eb-a943-4d20088aa235.PNG)

## configurations
Configurations can be found in the configs folder.
 As an example if you need to override Nginx configurations you can edit 	 laravel_nginx.config file in confgs/nginx/ folder.
## Data
Data like Nginx access.log error.log can be found in the data folder this will help to debug purposes.

## MySQL storage persistense
By default, all the data inside docker containers are destroyed after bringing down the containers. So each time fresh start a docker container you have to run the below commands to load the MySQL db.
```
php artisan migrate
php artisan db:seed
```
To avoid this dilemma docker MySQL service volume has been bound in the docker-compose.yml file.
```
volumes:
      - ./data/mysql/lib_data:/var/lib/mysql  
```
Remove this line if you need default behavior.

## Advanced usage
- **Xdebug**
	Xdebug is installed and enabled by default and uses port 9000. You just need to configure your IDE.

  For PHPStorm, all you need to do is:

-   Install the Browser extension:  [https://www.jetbrains.com/help/phpstorm/browser-debugging-extensions.html](https://www.jetbrains.com/help/phpstorm/browser-debugging-extensions.html)
-   Start listening, from the Menu: Run > Start Listening for PHP Debug Connections.

In API development you need to send a query param with the request like below

https://new-api.local/api/login?XDEBUG_SESSION_START=filter_string`

for the PhpStorm, the filter string is PHPSTORM
In postman, this can be automated using Pre-request Script.
`