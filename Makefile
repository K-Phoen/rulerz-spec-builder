tests:
	php ./bin/phpspec run -vvv

release:
	./vendor/bin/RMT release
