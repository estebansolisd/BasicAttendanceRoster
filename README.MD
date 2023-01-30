How to run this project?

Requirements
- Docker
- Docker compose


go to frontend folder (make sure to run this first, is very important)
run docker-compose up


go to backend folder

./vendor/bin/sail up
make sure all the container are up

in your backend container run php artisan db:seed


backend service should be running in localhost
frontend service should be running in http://localhost:8080/
