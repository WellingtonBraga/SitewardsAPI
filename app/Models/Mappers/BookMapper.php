<?php

namespace App\Models\Mappers;

use App\Core\Database;
use App\Models\Book;
use PDO as PDO;

class BookMapper
{

    /**
     * PDO Object to interact with database
     *
     * @var PDO
     */
    private $db;

    /**
     * Constructor of the class
     */
    public function __construct()
    {
        // Opening database connection
        $this->db = new Database();
        $this->db = $this->db->getInstance();
    }

    /**
     * This methos is used to save a new book.
     *
     * @param Book $book to be persisted
     * @return int response status code
     */
    public function save(Book $book)
    {
        $b = $this->findByName($book->getName());

        if (!is_null($b) && !is_bool($b)) {
            return 409;
        }

        $sql = "INSERT INTO `books` (`name`, `isbn13`, `isbn10`, `location`, `author`) VALUES (?, ?, ?, ?, ?)";

        $query = $this->db->prepare($sql);

        $query->bindValue(1, $book->getName());
        $query->bindValue(2, $book->getIsbn13());
        $query->bindValue(3, $book->getIsbn10());
        $query->bindValue(4, $book->getLocation());
        $query->bindValue(5, $book->getAuthor());

        if (!$query->execute()) {
            return 500;
        }

        return 200;

    }

    /**
     * This method is used to edit a book holder
     *
     * @param Book $book to be edited
     * @return int response status code
     */
    public function edit(Book $book)
    {
        $sql = "UPDATE `books` set `location` = ? WHERE  id = ?";

        $query = $this->db->prepare($sql);

        $query->bindValue(1, $book->getLocation());
        $query->bindValue(2, $book->getId());

        if (!$query->execute()) {
            return 500;
        }

        return 200;

    }

    /**
     * This method is used to delete a book from database.
     *
     * @param $id book's id
     * @return int response status code
     */
    public function delete($id){

        $b = $this->findById($id);

        if (is_null($b) || $b === false) {
            return 409;
        }

        $sql = "DELETE FROM `books` WHERE id = ?";

        $query = $this->db->prepare($sql);

        $query->bindValue(1, $id);

        if (!$query->execute()) {
            return 500;
        }

        return 200;
    }

    /**
     * This method is used to retrieve a list of books
     *
     * @return array list of books
     */
    public function findAll()
    {
        $sql = "SELECT * FROM books";

        $query = $this->db->prepare($sql);

        $query->execute();

        return $query->fetchAll(PDO::FETCH_CLASS, "App\Models\\Book");
    }

    /**
     * This method is used to retrieve a book from database using id
     *
     * @param int $id book's id
     * @return Book $book book object
     */
    public function findById(int $id)
    {
        $sql = "SELECT * FROM books WHERE id = ?";

        $query = $this->db->prepare($sql);

        $query->bindValue(1, $id);

        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS, "App\Models\\Book");

        return $query->fetch();
    }

    /**
     * This method is used to retrieve a book from database using name
     *
     * @param string $name book' name
     * @return int response status code or
     * @return Book book object retrieved by name
     */
    public function findByName(string $name)
    {
        $sql = "SELECT * FROM books WHERE name = ?";

        $query = $this->db->prepare($sql);

        $query->bindValue(1, $name);

        if (!$query->execute()) {
            return 500;
        }

        $query->setFetchMode(PDO::FETCH_CLASS, "App\Models\\Book");

        return $query->fetch();
    }

    /**
     * This method is used to retrieve a book from database using author name
     *
     * @param string $author name of the author
     * @return int response status code or
     * @return Book book object retrieved by name
     */
    public function findByAuthor(string $author)
    {
        $sql = "SELECT * FROM books WHERE author = ?";

        $query = $this->db->prepare($sql);

        $query->bindValue(1, $author);

        if (!$query->execute()) {
            return 500;
        }

        return $query->fetchAll(PDO::FETCH_CLASS, "App\Models\\Book");
    }

    /**
     * This method is used to retrieve a book from database using holder name
     *
     * @param string $name name of the holder
     * @return int response status code or
     * @return Book book object retrieved by name
     */
    public function findByHolder(string $name)
    {
        $sql = "SELECT * FROM books WHERE location = ?";

        $query = $this->db->prepare($sql);

        $query->bindValue(1, $name);

        if (!$query->execute()) {
            return 500;
        }

        return $query->fetchAll(PDO::FETCH_CLASS, "App\Models\\Book");
    }

    /**
     * This method is used to retrieve a book from database, update its holder
     * and call the method responsible to persist this updates.
     *
     * @param string $name name of the new holder
     * @param int $id id of the book
     * @param int $id id of the book
     * @return int response status code
     */
    public function changeHolder(string $name, int $id)
    {
        $book = $this->findById($id);

        if (is_null($book) || $book === false) {
            return 409;
        }

        $book->setLocation($name);

        return $this->edit($book);
    }

}