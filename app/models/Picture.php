<?php

class Picture{

    private $conn;

    public function __construct(){
        $this->conn = new Database();
    }

    public function add_photo($photo,$description,$lien){
        $this->conn->query("INSERT INTO POST (picture,description,lien,user_id) VALUES (?,?,?,?)");
        $this->conn->execute($photo, $description, $lien, $_SESSION['user_id']);
        // Return photo id
        $this->conn->query("SELECT MAX(id) as id FROM POST");
        $this->conn->execute();
        return $this->conn->resultSet();
    }

    public function map_picture_category($picture_id,$category_id){
        $this->conn->query("INSERT INTO post_category (post_id,category_id) VALUES (?,?);");
        $this->conn->execute($picture_id, $category_id);
    }
}
