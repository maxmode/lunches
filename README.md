# Lunches

This is an example project to show abilities of Symfony in terms of creating RESTful services

## Installation

```
composer install

cp app/config/parameters.yml.dist app/config/parameters.yml

php bin/console doctrine:database:drop
php bin/console doctrine:database:create
php bin/console doctrine:schema:create
```

## Tests execution
```
vendor/bin/phpunit -c phpunit.xml.dist
```

## API Reference

```
php bin/console server:run
```

And then go in browser to http://127.0.0.1:8000 to see list of available REST endpoints