<?php

class Picture{

    private $conn;

    public function __construct(){
        $this->conn = new Database();
    }

    public function add_photo($photo,$description){
        $this->conn->query("INSERT INTO POST (fichier,description,user_id) VALUES (?,?,?)");
        $this->conn->execute($photo, $description, $_SESSION['user_id']);
        // Return photo id
        $this->conn->query("SELECT MAX(id) as id FROM POST");
        $this->conn->execute();
        return $this->conn->resultSet();
    }

    public function map_picture_category($picture_id,$category_id){
        $this->conn->query("INSERT INTO post_category (post_id,category_id) VALUES (?,?);");
        $this->conn->execute($picture_id, $category_id);
    }

    public function getPostsByUserId($user_id){
        $this->conn->query("SELECT * FROM POST WHERE user_id = ?");
        $this->conn->execute($user_id);
        if ($this->conn->rowCount() > 0){
            return $this->conn->resultSet();
        }
        return false;
    }

    public function getPost($post_id){
        $this->conn->query("SELECT * FROM POST WHERE id = ?");
        $this->conn->execute($post_id);
        if ($this->conn->rowCount() > 0){
            return $this->conn->resultSet();
        }
        return false;
    }

    public function findPostCategory($post_id){
        $this->conn->query("SELECT * FROM post_category WHERE post_id = ?");
        $this->conn->execute($post_id);
        if ($this->conn->rowCount() > 0){
            return $this->conn->resultSet();
        }
        return false;
    }

    public function update_post($description,$post_id){
        $this->conn->query("UPDATE post SET description = ?  WHERE id = ?");
        $this->conn->execute($description, $post_id);
    }

    public function deletePost($post_id){
        $this->conn->query("DELETE FROM post WHERE id = ?");
        $this->conn->execute($post_id);
    }

    public function mapUserPost($post_id,$user_id,$op = 0){
        if ($op == 0){
            $this->conn->query("SELECT * FROM user_post where user_id = ? AND post_id = ?");
            $this->conn->execute($user_id, $post_id);
            if ($this->conn->rowCount() > 0){
                return $this->conn->resultSet();
            }
            return false;
        }elseif ($op == 1){
            $this->conn->query("INSERT INTO user_post(user_id,post_id,liked) VALUES(?,?,?)");
            $this->conn->execute($user_id, $post_id, 1);
        }else{
            $this->conn->query("INSERT INTO user_post(user_id,post_id,disliked) VALUES(?,?,?)");
            $this->conn->execute($user_id, $post_id, 1);
        }
    }

    public function incrementLikes($post_id){
        $this->conn->query("SELECT LIKES FROM POST WHERE id = ?");
        $this->conn->execute($post_id);
        $likesCounter = $this->conn->resultSet()[0]->LIKES + 1 ;
        $this->conn->query("UPDATE post set likes = ? WHERE id = ?");
        $this->conn->execute($likesCounter,$post_id);
    }

    public function decrementLikes($post_id){
        $this->conn->query("SELECT LIKES FROM POST WHERE id = ?");
        $this->conn->execute($post_id);
        $likesCounter = $this->conn->resultSet()[0]->LIKES - 1 ;
        $this->conn->query("UPDATE post set likes = ? WHERE id = ?");
        $this->conn->execute($likesCounter,$post_id);
    }

    public function incrementDislikes($post_id){
        $this->conn->query("SELECT DISLIKE FROM POST WHERE id = ?");
        $this->conn->execute($post_id);
        $dislikeCounter = $this->conn->resultSet()[0]->DISLIKE + 1 ;
        $this->conn->query("UPDATE post set dislike = ? WHERE id = ?");
        $this->conn->execute($dislikeCounter,$post_id);
    }

    public function decrementDislikes($post_id){
        $this->conn->query("SELECT DISLIKE FROM POST WHERE id = ?");
        $this->conn->execute($post_id);
        $dislikeCounter = $this->conn->resultSet()[0]->DISLIKE - 1 ;
        $this->conn->query("UPDATE post set dislike = ? WHERE id = ?");
        $this->conn->execute($dislikeCounter,$post_id);
    }

    public function deleteReaction($post_id,$user_id){
        $this->conn->query("DELETE FROM user_post WHERE user_id = ? AND post_id = ?");
        $this->conn->execute($user_id, $post_id);
    }
}
