test:
	php8.0 ./vendor/bin/phpunit --colors

push:
	make test
	git pull origin master
	git push origin master


.DEFAULT_GOAL: test