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

The application uses MySQL database to persist data. The file [db_sitewards.sql](db_sitewards.sql) is the backup of the database and must to be
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

## Endpoints

Below it is stated each endpoint in this api and its responsability. To see the endpoints declaration go to [index.php](index.php)
file.

Method | Pattern | Purpose | URL Params | Data Params
-------|---------|---------|------------|-------------
GET | /books | Return the full book's list. | - | -
GET | /books/name/{name} | Return only one book based in its name. | name=[string] | -
GET | /books/author/{author} | Return all books from an specified author. | author=[string] | -
GET | /books/holder/{holder} | Return all books which are with an specified holder (who belongs it now).  | holder=[string] | -
GET | /books/{id} | Return only one book based in its id.  | id=[int] | -
POST | /books | Add a new book.  | - | {"name":"Programming Pearls","isbn13":"978-0201657883","isbn10":"0201657880","author":"Jon Bentley","location":"Wellington"}
PUT | /books/{id} | Change the holder of an specified book.  | id=[int] | {"name":"Anton"}


## Built With

* [Slim Framework 3](https://www.slimframework.com/) - A micro framework for PHP