# SitewardsAPI

This project consists in a PHP Rest API developed for Sitewards.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Installing

#### dependencies
In order to installing the application dependencies, it is necessary to run composer install command. This command will
automatically download all project dependencies.

```
composer install
```

#### database

The application uses MySQL database to persist data. The file db_sitewards.sql is the backup of the database and must to be
restored.

##### Initialize database

To initialize the database for testing purposes, it was developed a system that uses the file [database_data.csv](database_data.csv) as data source.
So it is necessary to put in this file all the data that should be persisted. Below, it is stated the correct order to put
the information on this file.

```
book name, book_isbn13, book_isbn10, book_location, book_author
```

As we are using a .csv file, the information must to be separated using comma. Each row carries the information of one book which
will be stored as one row in database.

There is data on the database_data.csv file already, so, feel free to look it and add more data if you want.
After that, just initialize the application and the software will retrieve all the information in this file, and
it is going to persist them on the database.

## Built With

* [Slim Framework 3](https://www.slimframework.com/) - A micro framework for PHP