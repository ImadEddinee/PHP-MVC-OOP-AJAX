<?php

class Picture{

    private $conn;

    public function __construct(){
        $this->conn = new Database();
    }
}
