<?php
/*
 * PDO Database class
 * connect to database
 * prepare statements and return results
 */
class Database{
    private $host = HOST;
    private $user = USER;
    private $pass = PASS;
    private $db_name = DB_NAME;
    private $stmt;
    private $connection;

    public function __construct(){
        //SET DSN
        $dsn = "mysql:host=".$this->host.";dbname=".$this->db_name;
        $options = array(
            PDO::ATTR_PERSISTENT => true
        );
        // Create pdo instance
        try {
            $this->connection = new PDO($dsn,$this->user,$this->pass,$options);
        }catch (PDOException $e){
            print_r($e->getMessage());
        }
    }
    //Prepare Statement
    public function query($query){
        $this->stmt = $this->connection->prepare($query);
    }
    //Execute the Statement
    public function execute(...$data){
        return $this->stmt->execute($data);
    }
    // Get the resultSet
    public function resultSet(){
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function rowCount(){
        return $this->stmt->rowCount();
    }
}