<?php

class Categories extends Controller{

    private $CategoryModel;
    public function __construct(){
        if (!isLoggedIn())
            redirect("users/login");
        else
            $this->CategoryModel = $this->model("Category");
    }
    // Fetch all user's categories
    public function index(){

    }
    // Add new category
    public function add(){
        $name = $_GET['name'];
        if ($this->CategoryModel->findCategoryByName($name)){
            $data['category'] = $name;
            $data['category_error'] = "Category name already in use";
            $this->view("home",$data);
        }
        $this->CategoryModel->addCategory($name, $_SESSION['user_id']);
        redirect("home");
    }
}