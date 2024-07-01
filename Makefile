install:
	composer install
	npm install
	npm run build
	cp -p .env.example .env
	php artisan key:generate
	php artisan migrate

test:
	composer exec --verbose phpunit tests

lint:
	composer exec --verbose phpcs -- --standard=PSR12 app tests

test-coverage:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml
