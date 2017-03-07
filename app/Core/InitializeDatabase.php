<?php


namespace App\Core;


use App\Models\Book;
use App\Models\Mappers\BookMapper;

class InitializeDatabase
{

    private $mapper;

    /**
     * InitializeDatabase constructor.
     *
     */
    public function __construct()
    {
        $this->mapper = new BookMapper();
    }

    /**
     * This method starts the initialization of the database.
     */
    public function start(){
        $handle = fopen(dirname(__FILE__) . "/../../database_data.csv", "r");

        while ($data = fgetcsv($handle, 1000, ",")) {
            $book = new Book();
            $book->setName($data[0]);
            $book->setIsbn13($data[1]);
            $book->setIsbn10($data[2]);
            $book->setLocation($data[3]);
            $book->setAuthor($data[4]);

            $this->mapper->save($book);
        }
        fclose($handle);
        $this->setInitializeDatabaseToFalse();
    }

    public function setInitializeDatabaseToFalse() {
        $handle = fopen(dirname(__FILE__) . "/config/initializeDatabase.php", "w");
        fwrite($handle, "false");
        fclose($handle);
    }


}