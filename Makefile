install:
	composer install
	npm install
	cp -p .env.example .env
	php artisan key:generate
	php artisan migrate
	npm run build

test:
	composer exec --verbose phpunit tests

lint:
	composer exec --verbose phpcs -- --standard=PSR12 app tests

test-coverage:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml
