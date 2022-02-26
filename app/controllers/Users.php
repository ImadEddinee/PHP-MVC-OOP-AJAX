<?php

class Users extends Controller{

    private $userModel;

    public function __construct(){
        $this->userModel = $this->model("User");
    }
    public function index(){
        //Check if the user if already legged in

        // Redirect to the login Page
        header("location: ".ROOT."/Users/login");
    }

    public function register(){
        // Check if the request is comming from a form
        if ($_SERVER['REQUEST_METHOD']  == 'POST'){
            // Proccess the data
            //Sanitize data
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'title' => "Register",
                'name' => trim($_POST['name']),
                'name_error' => "",
                'email' => trim($_POST['email']),
                'email_error' => "",
                "password" => trim($_POST['password']),
                'password_error' => "",
                "confirm_password" => trim($_POST['confirm_password']),
                'confirm_password_error' => ""
            ];
            //Validate the name
            if (strlen($data['name']) < 5 || strlen($data['name']) > 15){
                $data['name_error'] = "The name should contain between 5 and 15 characters";
            }
            //Validate the email
            if (!filter_var($data['email'],FILTER_VALIDATE_EMAIL)){
                $data['email_error'] = "Please enter a validate email";
            }else{
                //check if the email is not already in use
                if ($this->userModel->findUserByEmail($data['email'])){
                    $data['email_error'] = "Email already in use";
                }
            }
            //Validate the password
            if (strlen($data['password']) < 8 ){
                $data['password_error'] = "The password should contain atleast 8 characters";
            }
            //Validate the confirm password
            if ($data['confirm_password'] !== $data['password']){
                $data['confirm_password_error'] = "Your passwords are not the same";
            }
            //Check if there is no errors
            if (empty($data['name_error']) && empty($data['email_error'])
                && empty($data['password_error']) && empty($data['confirm_password_error'])){
                die("sucess");
            }else{
                $this->view("users/register",$data);
            }
        }else{
            // Init Form data
            $data = [
                'title' => "Register",
                'name' => "",
                'name_error' => "",
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
        // Check if the request is comming from a form
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Process the data
            //Sanitize the form data
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_error' => '',
                'password_error' => ''
            ];
            //Validate email
            if (!filter_var($data['email'],FILTER_VALIDATE_EMAIL) || empty($data['email'])){
                $data['email_error'] = "Please enter a valid email";
            }
            //Validate Password
            if (empty($data['password'])){
                $data['password_error'] = "Please enter your password";
            }
            //Check if therre is no errors
            if (empty($data['email_error']) && empty($data['password_error'])){
                die("suceess");
            }else{
                $data['title'] = "Login Page";
                $this->view("users/login",$data);
            }
        }else{
            $data = [
                'title' => "Login Page",
                'email' => "",
                'email_error' => "",
                'password' => "",
                'password_error' => ""
            ];
            // Load the Login form
            $this->view("users/login",$data);
        }
    }
}