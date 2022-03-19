<?php

class Home extends Controller{
    
    public function __construct(){
        if (!isLoggedIn())
            redirect("users/login");
    }
    // Fetch all categories of a user and display a form to add a picture
    public function index(){
        $data = [
          'title' => 'Home Page'
        ];
        $this->view("home/index",$data);
    }
}