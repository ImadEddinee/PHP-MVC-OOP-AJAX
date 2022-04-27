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
        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            //TODO : add lowercase search
            $name = trim($_POST['name']);
            $data = [
                'title' => 'Home Page',
                'category' => $name,
                'picture_link' => '',
                'picture_description' => '',
                'category_error' => "Category name already in use",
                'categories' => $this->CategoryModel->getAllCategories()
            ];
            if ($this->CategoryModel->findCategoryByName($name)){
                $data[] = [
                    'category' => $name,
                    'category_error' => "Category name already in use",
                ];
                $this->view("home/index",$data);
            }else{
                $this->CategoryModel->addCategory($name, $_SESSION['user_id']);
                redirect("home");
            }
        }
    }
}