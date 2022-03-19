<?php

class Categories extends Controller{

    private $CategorieModel;
    public function __construct(){
        if (!isLoggedIn())
            redirect("users/login");
        else
            $this->CategorieModel = $this->model("Categorie");
    }
    // Fetch all user's categories
    public function index(){

    }
    // Add new categorie
    public function add(){

    }
}