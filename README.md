# Developer Test

This application is an API for an ad quality management team for sort ads based on specific features.

Once you have installed the dependencies and the docker container is running, there are 3 available endpoints:
- Endpoint for data creation: http://localhost/. Also, the data can be created using the command app:create-data
- Endpoint for score calculation: http://localhost/calculate/score. Also, the score can be updated using the command app:update-score
- Endpoint for quality department: http://localhost/calculate/quality/deparment
- Endpoint for user: http://localhost/calculate/public/ad

# About The Architecture

My first approach was to develop this application using DDD and CQRS, but I thought that it could add cognitive complexity to a simple domain. Therefore, I decided to use the default Symfony architecture.

## Instructions
- Install Docker https://www.docker.com/get-started
- `make build` to build the containers
- `make start` to start the containers
- `make stop` to stop the containers
- `make restart` to restart the containers
- `make prepare` to install dependencies with composer (once the project has been created)
- `make run` to start a web server listening on port 1000 (8000 in the container)
- `make logs` to see application logs
- `make ssh-be` to SSH into the application container
