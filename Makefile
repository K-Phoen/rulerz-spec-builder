tests:
	php ./bin/phpspec run -vvv

release:
	./vendor/bin/RMT release

rusty:
	php ./bin/rusty check --bootstrap-file=./vendor/autoload.php src
