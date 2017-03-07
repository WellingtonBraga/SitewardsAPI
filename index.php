<?php
require_once 'vendor/autoload.php';

use \Slim\App as App;
use App\Controllers\BooksController as BooksController;

// Initialize Database with data
$bookController = new BooksController();
$bookController->initializeDatabase();

$configuration = [
    'settings' => [
        'displayErrorDetails' => false,
    ],
];

$container = new \Slim\Container($configuration);

$app = new App($container);

// Return the full book's list.
$app->get('/books', BooksController::class . ':listAllBooks');

// Return only one book based in its name
$app->get('/books/name/{name}', BooksController::class . ':findByName');

// Return all books from an specified author
$app->get('/books/author/{author}', BooksController::class . ':findByAuthor');

// Return all books which are with an specified holder (who belongs it now)
$app->get('/books/holder/{holder}', BooksController::class . ':findByHolder');

// Return only one book based in its id
$app->delete('/books/{id}', BooksController::class . ':delete');

// Add a new book
$app->post('/books', BooksController::class . ':add');

// Change the holder of an specified book
$app->put('/books/{id}', BooksController::class . ':changeHolder');

$app->run();