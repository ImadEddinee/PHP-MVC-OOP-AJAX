<?php

class Categorie
{

    private $conn;

    public function __construct(){
        $this->conn = new Database();
    }

    // Check for redundant category name
    public function findCategoryByName($name){
        $this->conn->query("SELECT * FROM CATEGORIE WHERE name = ?");
        $this->conn->execute($name);
        if ($this->conn->rowCount() > 0){
            return true;
        }
        return false;
    }

    // Add new Category
    public function addCategory($name,$user_id){
        $this->conn->query("INSERT INTO CATEGORIE (name,user_id) VALUES (?,?)");
        $this->conn->execute($name, $user_id);
    }

    // Get all categories
    public function getAllCategories(){
        $this->conn->query("SELECT * FROM CATEGORIE");
        $this->conn->execute();
        return $this->conn->resultSet();
    }
}