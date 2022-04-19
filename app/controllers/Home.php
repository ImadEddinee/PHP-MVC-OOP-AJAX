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
            'categories' => $this->categoryModel->getAllCategories()
        ];
        $this->view("home/index",$data);
    }
}