<?php

namespace App\Controllers;

use App\Core\InitDBFacade;
use App\Helpers\TraitConfig;
use App\Models\Book;
use App\Models\Mappers\BookMapper;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BooksController
{
    use TraitConfig;

    public function initializeDatabase(){
        $this->setUpConfiguration();

        if ($this->config["initialize"] === true) {
            $init = new InitDBFacade();
            $init->start();
        }
    }

    /**
     * This method is in charge of list all books in database
     *
     * @param Request $request
     * @param Response $response
     */
    public function listAllBooks(Request $request, Response $response) {
        $mapper = new BookMapper();

        // Find all books
        $books = $mapper->findAll();

        $response->getBody()->write(json_encode($books));
    }

    /**
     * This method is in charge of create a new book in database
     *
     * @param Request $request
     * @param Response $response
     * @return response status code
     */
    public function add(Request $request, Response $response) {
        $mapper = new BookMapper();

        $data = $request->getParsedBody();

        // If this two keys doesn't exists, it means that we are receiving
        // an json with the information, so we need to parse it in order to retrieve those information
        // and convert them to array
        if (!isset($data["name"]) && !isset($data["author"])) {
            $data = json_decode(array_keys($data)[0], true);
        }

        // Creating new book object
        $book = new Book();
        $book->setName($data["name"]);
        $book->setIsbn10($data["isbn10"]);
        $book->setAuthor($data["author"]);
        $book->setIsbn13($data["isbn13"]);
        $book->setLocation($data["location"]);

        // Persist book
        return $response->withStatus($mapper->save($book));
    }

    /**
     * This method is in charge of delete a book in database
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return response status code
     */
    public function delete(Request $request, Response $response, array $args){
        $id = $args["id"];
        $mapper = new BookMapper();

        return $response->withStatus($mapper->delete($id));
    }

    /**
     * This methos is in charge of find a book by its name
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return static
     */
    public function findByName(Request $request, Response $response, array $args) {
        $name = $args["name"];
        $mapper = new BookMapper();

        $book = $mapper->findByName($name);

        if (is_null($book) || is_int($book)) {
            return $response->withStatus($book);
        }

        $response->getBody()->write(json_encode($book));
    }

    /**
     * This methos is in charge of find a book by its author
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return static
     */
    public function findByAuthor(Request $request, Response $response, array $args) {
        $author = $args["author"];
        $mapper = new BookMapper();

        $book = $mapper->findByAuthor($author);

        if (is_null($book) || is_int($book)) {
            return $response->withStatus($book);
        }

        $response->getBody()->write(json_encode($book));
    }

    /**
     * This methos is in charge of find a book by the name of who is holding it
     *
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return static
     */
    public function findByHolder(Request $request, Response $response, $args) {
        $holder = $args["holder"];

        $mapper = new BookMapper();

        $book = $mapper->findByHolder($holder);

        if (is_null($book) || is_int($book)) {
            return $response->withStatus($book);
        }

        $response->getBody()->write(json_encode($book));
    }

    /**
     * This methos is in charge of change the holder of a book
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return static
     */
    public function changeHolder(Request $request, Response $response, array $args) {
        $id = $args["id"];
        
        $mapper = new BookMapper();

        $data = $request->getParsedBody();
        // If this keys doesn't exists, it means that we are receiving
        // an json with the information, so we need to parse it in order to retrieve this information
        // and convert it to array
        if (!isset($data["name"])) {
            $data = json_decode(array_keys($data)[0], true);
        }

        $holder = $data["name"];

        $book = $mapper->changeHolder($holder, $id);
        if (is_null($book) || is_int($book)) {
            return $response->withStatus($book);
        }

        $response->getBody()->write(json_encode($book));

    }
}