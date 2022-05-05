<?php

class Category
{

    private $conn;

    public function __construct(){
        $this->conn = new Database();
    }

    // Check for redundant category name
    public function findCategoryByName($name){
        $this->conn->query("SELECT * FROM CATEGORY WHERE name = ?");
        $this->conn->execute($name);
        if ($this->conn->rowCount() > 0){
            return true;
        }
        return false;
    }

    public function getCategoryById($category_id){
        $this->conn->query("SELECT * FROM CATEGORY WHERE id = ?");
        $this->conn->execute($category_id);
        return $this->conn->resultSet();
    }

    // Add new Category
    public function addCategory($name,$user_id){
        $this->conn->query("INSERT INTO CATEGORY (name,user_id) VALUES (?,?)");
        $this->conn->execute($name, $user_id);
    }

    // Get all categories
    public function getAllCategories(){
        $this->conn->query("SELECT * FROM CATEGORY");
        $this->conn->execute();
        return $this->conn->resultSet();
    }

    public function deleteCategories($post_id){
        $this->conn->query("DELETE FROM post_category WHERE post_id = ?");
        $this->conn->execute($post_id);
    }
}