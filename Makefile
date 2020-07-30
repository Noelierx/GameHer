# Git server
install: ## Install dockers
	docker-compose up -d
	${MAKE} install-composer-deps
	${MAKE} setup-db
	#${MAKE} setup-npm  ## commented because very slow
	${MAKE} end-message


install-composer-deps: ## Install composer dependencies
	docker exec -i gh-web sh -c 'composer clear-cache && composer install'
	docker exec -i gh-web sh -c 'cp .env .env.local'

setup-db: ## Imports database structure and content to mariadb
	docker exec -i gh-web sh -c 'php bin/console do:da:dr --force'
	docker exec -i gh-web sh -c 'php bin/console do:da:cr'
	docker exec -i gh-web sh -c '/usr/bin/php bin/console do:mi:mi -n'

setup-ssl: ##Create openssl keys
	docker exec -i gh-web sh -c 'openssl genrsa -passout pass:test -out var/jwt/private.pem -aes256 4096'
	docker exec -i gh-web sh -c 'openssl rsa -passin pass:test -pubout -in var/jwt/private.pem -out var/jwt/public.pem'

setup-npm: #install npm dependencies
	docker exec -i gh-web sh -c 'npm install'

assets:
	docker exec -i gh-web sh -c 'npm run dev'

up:
	docker-compose up -d --build

stop:
	docker-compose stop

tty:
	docker exec -ti gh-web bash

db:
	docker exec -ti gh-mariadb sh -c 'mysql -u gameher -pgameherpwd gameher'

end-message: #
	@echo "-------------------------------------------------------------"
	@echo "|                                                           |"
	@echo "|              DOCKER SETUP ENDED SUCCESSFULLY              |"
	@echo "|                                                           |"
	@echo "-------------------------------------------------------------"
	@echo ""
