<?php

class User {
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }
    //Verifie user Credentials
    public function login($email,$password){
        $this->conn->query("SELECT * FROM user WHERE email = ?");
        $this->conn->execute($email);
        if ($row = $this->conn->resultSet()){
            $hashed_password = $row[0]->password;
            if (password_verify($password,$hashed_password)){
                return $row;
            }
        }
        return false;
    }
    // Register the user
    public function register($data){
        $this->conn->query("INSERT INTO user (username,email,password) VALUES (?,?,?)");
        if ($this->conn->execute($data['username'],$data['email'],$data['password'])){
            return true;
        }
        return false;
    }
    //find user by username
    public function findUserByUsername($username){
        $this->conn->query("SELECT * FROM user WHERE username = ?");
        $this->conn->execute($username);
        $this->conn->resultSet();
        if ($this->conn->rowCount() > 0){
            return true;
        }
        return false;
    }
    // findUserByEmail
    public function findUserByEmail($email){
        $this->conn->query("SELECT * FROM user WHERE email = ?");
        $this->conn->execute($email);
        $this->conn->resultSet();
        if ($this->conn->rowCount() > 0){
            return true;
        }
        return false;
    }
    // Get user info
    public function getUser($user_id){
        $this->conn->query("SELECT * FROM USER WHERE id = ?");
        $this->conn->execute($user_id);
        if ($this->conn->rowCount() > 0){
            return $this->conn->resultSet();
        }
        return false;
    }
    // Update user password
    public function resetPassword($email,$password){
        $this->conn->query("UPDATE user SET password = ? WHERE email = ?");
        if ($this->conn->execute($password,$email)){
            return true;
        }
        return false;
    }
}