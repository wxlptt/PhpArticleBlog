# Assignment 2

## Setup

Ensure you create the database schema with the `database/schema.sql` file. The credentials for the database can be added within the Repository.php file.

## Install dependencies

```
npm i
```

```
composer install
```

If you need to re-generate the autoload files, you can run:

```
composer dump-autoload
```

## Running the application

You can run the application using the built-in PHP web server, setting the document root to `public/`

For example:

```
php -S localhost:7777 -t public/
```

### Compile and hot-reload CSS assets

```
npm run dev
```
