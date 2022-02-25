<?php

class Users extends Controller{

    public function __construct(){

    }
    public function index(){
        //Check if the user if already legged in

        // Redirect to the login Page
        header("location: ".ROOT."/Users/login");
    }

    public function register(){
        // Check if the request is comming from a form
        if ($_SERVER['REQUEST_METHOD']  = 'POST'){
            // Proccess the data
        }else{
            // Init Form data
            $data = [
                'title' => "Register",
                'username' => "",
                'username_error' => "",
                'email' => "",
                'email_error' => "",
                "password" => "",
                'password_error' => "",
                "confirm_password" => "",
                'confirm_password_error' => ""
            ];
            // Load the Register form
            $this->view("users/register",$data);
        }
    }

    public function login(){
        $data = [
            'title' => "Login"
        ];
        // Load the Login form
        $this->view("users/login",$data);
    }
}