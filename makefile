build: 
	- docker-compose up --build
start:
	- docker-compose up -d
watch:
	- docker-compose run npm run watch
stop:
	- docker-compose stop
down:
	- docker-compose down
go-inside-php-container:
	- docker-compose run php bash
migrate-update: 
	- docker-compose run php php bin/console doctrine:schema:update --force 
entity: 
	- docker-compose run php php bin/console make:entity
form: 
	- docker-compose run php php bin/console make:form   
check-version: 
	- docker-compose run php php bin/console --version  
	
route-show: 
	- docker-compose run php php bin/console debug:router
migrate: 
	- docker-compose run php php bin/console doctrine:migrations:migrate

# clear-config:
# 	- docker-compose run php php artisan config:cache
# connect-php:
# 	- docker-compose run php sh
# autoload:
# 	- docker-compose run composer dump-autoload
# migrate:
# 	- docker-compose run php php artisan migrate
# run-cron:
# 	- docker-compose run php php artisan schedule:run >> /dev/null 2>&1
# install:
# 	- docker-compose up -d
# 	- docker-compose run composer composer install
# 	- docker-compose run npm install
# 	- docker-compose run npm run prod
# 	- docker-compose run php php artisan migrate
# 	- docker-compose run php php artisan db:seed

# refresh:
# 	- docker-compose run php php artisan config:cache
# 	- docker-compose run php php artisan migrate:refresh --seed

# fresh:
# 	- docker-compose run php php artisan migrate:fresh --seed

# update:
# 	- docker-compose run php php artisan down
# 	- git pull
# 	- docker-compose run composer composer install
# 	- cp -f .test-server.env src/.env
# 	- docker-compose run php php artisan config:cache
# 	- docker-compose run php php artisan migrate
# 	- docker-compose run php php artisan up

# refresh-remote:
# 	- docker-compose run php php artisan migrate:refresh
# 	- docker-compose run php php artisan db:seed
# 	- docker-compose run php php artisan passport:install

# remote-deploy:
# 	- ssh toi@34.71.132.53 'cd /home/toi/projects/class.tech2.vn && make update'

# clear-cache-remote: