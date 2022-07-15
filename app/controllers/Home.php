<?php

class Home extends Controller{

    private $categoryModel;
    public function __construct(){
        if (!isLoggedIn())
            redirect("users/login");
        $this->categoryModel = $this->model("category");
    }
    // Fetch all categories of a user and display a form to add a picture
    public function index(){
        $data = [
            'title' => 'Home Page',
            'picture_description' => '',
            'checked_categories' => array(),
            'categories' => $this->categoryModel->getUserCategory($_SESSION['user_id'])
        ];
        $this->view("home/index",$data);
    }
}