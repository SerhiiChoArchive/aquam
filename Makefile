push:
	php artisan test
	git pull origin master
	git push origin master

test:
	php artisan test

.DEFAULT_GOAL: test