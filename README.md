# <center>Next Basket PHP Assessment</center>
This project is a simple Laravel Microservice that provides a RESTful API for a simple user registration and login system. The project is uses technologies such as Laravel, Docker, and MySQL.
# Getting Started
For you to start using this project, you need to have Docker and Docker Compose installed on your machine. If you don't have Docker and Docker Compose installed, you can download and install them from the following links:
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
# Installation
To install and run this project on your machine, you need to follow the following steps:
1. Clone the repository to your local machine
```bash 
git clone https://github.com/emmadedayo/nestbasketAssessment.git
``` 
2. Change directory to the project directory
```bash
cd nestbasketAssessment
```
3. Theere are two folders in the project directory, the `user-mircoservice` folder and the `notification-mircoservice` folder. The `notification-mircoservice` folder contains the Laravel Microservice that consume user event created by `user-microservice`  and the `user-microservice` folder contains a simple application that create and send to a bus-messenger a user created event. Change directory to the `user-microservice` folder
```bash
cd user-microservice
```
4. Run composer install and copy the .env.example file to .env this will create a .env file in the root of the project directory and generate a new application key
```bash
composer install
cp .env.example .env
php artisan key:generate
```
ensure you are in the `user-microservice` folder after that 
5. Go back to the root of the project directory and navigate to the `notification-microservice` folder
```bash
cd ..
cd notification-microservice
```
6. Run composer install and copy the .env.example file to .env this will create a .env file in the root of the project directory and generate a new application key
```bash
composer install
cp .env.example .env
php artisan key:generate
```
ensure you are in the `notification-microservice` folder after that
7. Go back to the root of the project directory and be sure you are seeing the `docker-compose.yml` file
```bash
cd ..
docker-compose build
```
This will build the docker images for the project and install all the dependencies, ensure that this container is running without any error before you proceed to the next step
Here are this list of containers that should be running
1. **database**: This is the MySQL database container that stores the user data
2. **rabbitmq**: This is the RabbitMQ container that is used to queue the user created event
3. **user-service-microservice**: This is the user microservice container
4. **queue-service**: This is the container worker that process background jobs
5. **notification-microservice**: This is the notification microservice container that listens to the user created event 
6. **migration-service**: This is the migration container that runs the migration for the user microservice

### Important Notes

- **Notification Microservice**: May display an error if RabbitMQ is still running. Please check if RabbitMQ is running on your machine, i have to delay the notification microservice to wait for the RabbitMQ to be up and running before it starts
- **Migration Service**: May display an error if the database is not fully running. Make sure the database is up and running before initiating migrations, i have to delay the migration service to wait for the database to be up and running before it starts
if you encounter any error, please stop the containers and run the `docker-compose build` command again
- **Running the application**: After the containers are running without any error, open your terminal and navigate to the root of the project directory and run the following command
```bash
docker-compose up -d
```
After running the command, the user-service-microservice will be running on `http://localhost:8080`, then open a new terminal and run the following command
```bash
docker exec -it notification-microservice /bin/sh
```
This will open the notification-microservice container, then run the following command
```bash
tail -f storage/logs/laravel.log
```
After this, go to your postman or create an http request to `http://127.0.0.1:8000/user/add` with the following payload
```json
{
    "firstName": "Emmanuel",
    "lastName": "Adenagbe",
    "email": "test009@gmail.com"
}
```
After sending the request, go back to the terminal where you are tailing the log file and you should see a log that the user created event has been received or i have added the command to tail the log file in the `notification-microservice` container to the `docker-compose.yml` file so you can run the following command
```bash
docker-compose logs -f notification-microservice
```
This will tail the log file for the notification-microservice container or check the real time log in the container
# Duns and Solutions
If myqsl folder is deleted, it will throw an error, to fix this, open the database container and run the following command
```bash
docker exec -it database /bin/sh
```
This will open the database container, login and create a new database with the following command
```bash
mysql -u root -p
```
Enter the password `password` and run the following command
```root
CREATE DATABASE user_test;
```
This will create a new database for the user microservice, then exit the database container and run the following command
```bash
docker-compose down
docker-compose up -d
```
This will recreate the database container and the user microservice container

# Running the tests
To run the tests for the user microservice, open your terminal and navigate to the root of the project directory and run the following command
```bash
docker exec -it user-service-microservice /bin/sh
```
This will open the user-service-microservice container, then run the following command
```bash
php artisan test
```
This will run the tests for the user microservice


