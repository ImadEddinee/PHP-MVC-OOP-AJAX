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
    //Bind values
    public function bind($param,$value,$type = null){
        if (is_null($type)){
            switch (true){
                case is_int($type):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($type):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($type):
                    $type = PDO::PARAM_NULL;
                    break;
                case is_string($type):
                    $type = PDO::PARAM_STR;
                    break;
            }
        }
        $this->stmt->bindValue($param,$value,$type);
    }
    //Execute the Statement
    public function execute(){
        return $this->stmt->execute();
    }
    // Get the resultSet
    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }
    // Get a single result
    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }
}