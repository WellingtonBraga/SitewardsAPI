<?php

namespace App\Core;


use App\Helpers\TraitConfig;
use PDO as PDO;

Class Database{

    use TraitConfig;

    private $pdo;

    /**
     * Constructor of the class
     */
    public function __construct(){

        $this->setUpConfiguration();

        $this->pdo = new PDO("mysql:host=".$this->config["db"]["host"].";dbname=".$this->config["db"]["database"].";
			charset=utf8",$this->config["db"]["user"],$this->config["db"]["password"]);

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
    }

    /**
     * Method responsible to return an PDO instance
     *
     * @return PDO pdo instance to interact with database
     */
    public function getInstance(){
        return $this->pdo;
    }
}
?>