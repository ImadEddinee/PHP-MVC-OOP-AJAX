<?php

class Comment {

    private $conn;

    public function __construct(){
        $this->conn = new Database();
    }

    public function findCommentsByPostId($post_id){
        $this->conn->query("SELECT * FROM commentaire WHERE post_id = ?");
        $this->conn->execute($post_id);
        if ($this->conn->rowCount() > 0){
            return $this->conn->resultSet();
        }
        return false;
    }

    public function addComment($contenu,$post_id){
        $this->conn->query("INSERT INTO commentaire (contenu, user_id, post_id) VALUES (?,?,?)");
        $this->conn->execute($contenu, $_SESSION['user_id'], $post_id);
    }

    public function getComment($comment_id){
        $this->conn->query("SELECT * FROM commentaire WHERE id = ?");
        $this->conn->execute($comment_id);
        if ($this->conn->rowCount() > 0){
            return $this->conn->resultSet();
        }
        return false;
    }

    public function deleteComment($comment_id){
        $this->conn->query("DELETE FROM commentaire WHERE id = ?");
        $this->conn->execute($comment_id);
    }
}