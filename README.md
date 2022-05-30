You need to have at least PHP 7.4 and composer.

```
git clone https://github.com/tomopongrac/authors-client.git
cd authors-client
composer install
symfony server:start
```

Example .env file

```
API_URL=""
API_USERNAME=""
API_PASSWORD=""
```

For creating a new author from CLI use command
```
php ./bin/console app:create-author
```