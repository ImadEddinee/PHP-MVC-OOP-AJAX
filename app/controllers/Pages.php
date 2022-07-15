<?php

class Pages extends Controller{

    private $userModel;
    public function __construct(){
        $this->userModel = $this->model("user");
    }

    public function index($str = ""){
        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            $users = $this->userModel->getUserByKeyword($str);
            $response = "<ul class='list-group'>";
            foreach ($users as $user){
                $response .= "<a href='".ROOT."users/0/".$user->id."'><li class='list-group-item'>$user->username</li></a>";
            }
            $response .= "</ul>";
            print_r($response);
        }else{
            $data['title'] = "Welcome";
            $this->view("pages/index",$data);
        }
    }

    public function features(){
        $data['title'] = "Features";
        $this->view("pages/features",$data);
    }
}
