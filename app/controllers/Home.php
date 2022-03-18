<?php

class Home extends Controller{
    
    public function __construct(){
        if (!isLoggedIn())
            redirect("users/login");
    }

    public function index(){
        $data = [
          'title' => 'Home Page'
        ];
        $this->view("home/index",$data);
    }
}