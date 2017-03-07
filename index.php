<?php
require_once 'vendor/autoload.php';

use \Slim\App as App;
use App\Controllers\BooksController as BooksController;

// Initialize Database with data
$bookController = new BooksController();
$bookController->initializeDatabase();

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$container = new \Slim\Container($configuration);

$app = new App($container);

$app->get('/books', BooksController::class . ':listAllBooks');

$app->get('/books/name/{name}', BooksController::class . ':findByName');

$app->get('/books/author/{author}', BooksController::class . ':findByAuthor');

$app->get('/books/holder/{holder}', BooksController::class . ':findByHolder');

$app->delete('/books/{id}', BooksController::class . ':delete');

$app->post('/books', BooksController::class . ':add');

$app->put('/books/{id}', BooksController::class . ':changeHolder');

$app->run();