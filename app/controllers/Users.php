<?php

class Users extends Controller{

    private $userModel;
    private $pictureModel;

    public function __construct(){

        $this->userModel = $this->model("User");
        $this->pictureModel = $this->model("Picture");
    }

    public function index($sort = 0,$user_id = -1){
        if ($user_id == -1){
            $user_id = $_SESSION['user_id'];
        }
        // Get user details
        $user = $this->userModel->getUser($user_id)[0];
        if (!$user){
            die("user id not found");
        }
        // Get Posts shared by the user
        $posts = $this->pictureModel->getPostsByUserId($user_id);
        // Sort posts by likes
        if ($sort){
            for ($i=0;$i<count($posts);$i++){
                for ($j=$i+1;$j<count($posts);$j++){
                    if ($posts[$i]->likes < $posts[$j]->likes){
                        $temp = $posts[$i];
                        $posts[$i] = $posts[$j];
                        $posts[$j] = $temp;
                    }
                }
            }
        }
        $data = [
            'title' => "Profile",
            'user_id' => $user->id,
            'username' => $user->username,
            'posts' => $posts
        ];
        $this->view("users/index",$data);
    }


    public function register(){
        // Check if the request is comming from a form
        if ($_SERVER['REQUEST_METHOD']  == 'POST'){
            // Proccess the data
            //Sanitize data
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'title' => "Register",
                'username' => trim($_POST['username']),
                'username_error' => "",
                'email' => trim($_POST['email']),
                'email_error' => "",
                "password" => trim($_POST['password']),
                'password_error' => "",
                "confirm_password" => trim($_POST['confirm_password']),
                'confirm_password_error' => ""
            ];
            //Validate the name
            if (strlen($data['username']) < 5 || strlen($data['username']) > 25){
                $data['name_error'] = "The name should contain between 5 and 25 characters";
            }else if ($this->userModel->findUserByUsername($data['username'])){
                // Check if the username is unique
                $data['username_error'] = "Username is already in use !";
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
            if (empty($data['username_error']) && empty($data['email_error'])
                && empty($data['password_error']) && empty($data['confirm_password_error'])){
                // Hash the password
                $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
                // Persiste the data in  database
                if ($this->userModel->register($data)){
                    flash("user_register","You are registered you can Log in");
                    redirect("users/login");
                }else{
                    die("Something went wrong");
                }
            }else{
                $this->view("users/register",$data);
            }
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
        // Check if the request is comming from a form
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Process the data
            //Sanitize the form data
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'title' => "Login Page",
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
            //Check if the email exists
            if (!$this->userModel->findUserByEmail($data['email'])){
                $data['email_error'] = "Email is incorrect";
            }
            //Check if therre is no errors
            if (empty($data['email_error']) && empty($data['password_error'])){
                $result = $this->userModel->login($data['email'],$data['password']);
                if ($result){
                    createUserSession($result);
                    redirect("Home");
                }else{
                    flash("user_login","Bad Credentials","alert alert-danger");
                    redirect("users/login");
                }
            }else{
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
    public function password(){
        if ($_SERVER['REQUEST_METHOD'] == "GET"){
            // Init form data
            $data = [
              'title' => 'Email Verification',
                'email' => '',
                'email_error' => ''
            ];
            $this->view("users/email_verification",$data);
        }else{
            // Sanitize data
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'email' => trim($_POST['email']),
                'email_error' => ''
            ];
            // Check if the email exists
            if (!$this->userModel->findUserByEmail($data['email'])){
                $data['email_error'] = "The email you entered is incorrect !";
            }
            // Check if there are no errors
            if (empty($data['email_error'])){
                // Store the email in session
                $_SESSION['email'] = $data['email'];
                // Generate and Store the code that that will be sent in the session
                $this->generateCode();
                // Send an email
                $this->send_email();
                flash("email_code","The email is sent successfully");
                redirect("users/code");
            }else{
                $data['title'] = "Email Verification";
                $this->view("users/email_verification",$data);
            }
        }
    }
    // Generate a random integer that contains 4 digits
    private function generateCode(){
        if (isset($_SESSION['code'])){
            // Unset the previous code stored is session
            unset($_SESSION['code']);
        }
        $code = rand(1000,9999);
        $_SESSION['code'] = $code;
    }
    public function resend(){
        // Generate the code
        $this->generateCode();
        $this->send_email();
        flash("email_code","The email is sent successfully");
        redirect("users/code");
    }
    private function send_email(){
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = "true";
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '465';
        $mail->Username = 'hajaliimadeddine@gmail.com';
        $mail->Password = 'oxtnqjbmkktbkzaa';
        try {
            $mail->setFrom("hajaliimadeddine@gmail.com");
        } catch (\PHPMailer\PHPMailer\Exception $e) {
        }
        $mail->Subject = 'Code de verification';
        $mail->Body = 'Votre code de verification est : '.$_SESSION['code'];
        if (isset($_SESSION['user_email'])){
            $_SESSION['email'] = $_SESSION['user_email'];
        }
        $mail->addAddress($_SESSION['email']);
        $mail->send();
    }
    public function code(){
        if ($_SERVER['REQUEST_METHOD'] == "GET"){
            // Init data
            $data = [
                'title' => 'Code Verification',
                'code' => '',
                'code_error' => ''
            ];
            $this->view("users/code_verification",$data);
        }else{
            $data = [
                'title' => 'Code Verification',
                'code' => trim($_POST['code']),
                'code_error' => ''
            ];
            // Check if the code in a number
            if (!filter_var($data['code'],FILTER_VALIDATE_INT)){
                $data['code_error'] = "Please enter a valid code ";
            }
            //Check if the code entered match the code sent
            if (!($data['code'] == $_SESSION['code'])){
                $data['code_error'] = "The code you entered is incorrect !";
            }
            //Check if there are no errors
            if (empty($data['code_error'])){
                redirect("users/reset");
            }else{
                $this->view("users/code_verification",$data);
            }
        }
    }
    public function reset(){
        if ($_SERVER['REQUEST_METHOD'] === "GET"){
            //Init data
            $data = [
              'title' => "Reset Password",
              'password' => '',
              'password_error' => '',
              'confirm_password' => '',
              'confirm_password_error' => ''
            ];
            $this->view("users/reset_password",$data);
        }else{
            // Proccess data
            $data = [
                'title' => "Reset Password",
              'password' => $_POST['password'],
                'password_error' => '',
                'confirm_password' => $_POST['confirm_password'],
                'confirm_password_error' => ''
            ];
            // check if the password is valid
            if (strlen($data['password']) < 8){
                $data['password_error'] = "Your password should atleast contain 8 characters";
            }elseif(!($data['password'] === $data['confirm_password'])){
                $data['confirm_password_error'] = "The passwords you entered does not match !";
            }
            // Check if there are no errors
            if (empty($data['password_error']) && empty($data['confirm_password_error'])){
                // Hash the password
                $encoded_pass = password_hash($data['password'],PASSWORD_DEFAULT);
                $this->userModel->resetPassword($_SESSION['email'],$encoded_pass);
                unset($_SESSION['email']);
                flash("reset_pass","Your Password is updated you can login now");
                redirect("users/login");
            }else{
                $this->view("users/reset_password",$data);
            }
        }
    }

    public function send_mail(){
        // check if account isn't already confirmed
        if (!$_SESSION['enabled']){
            $this->generateCode();
            // Send an email
            $this->send_email();
            flash("email_code","The email is sent successfully");
            redirect("users/confirm");
        }
    }

    public function confirm(){
        if ($_SERVER['REQUEST_METHOD'] == "GET"){
            // Init data
            $data = [
                'title' => 'Email Verification',
                'code' => '',
                'code_error' => ''
            ];
            $this->view("users/enable_account",$data);
        }else{
            $data = [
                'title' => 'Email Verification',
                'code' => trim($_POST['code']),
                'code_error' => ''
            ];
            // Check if the code in a number
            if (!filter_var($data['code'],FILTER_VALIDATE_INT)){
                $data['code_error'] = "Please enter a valid code ";
            }
            //Check if the code entered match the code sent
            if (!($data['code'] == $_SESSION['code'])){
                $data['code_error'] = "The code you entered is incorrect !";
            }
            //Check if there are no errors
            if (empty($data['code_error'])){
                $_SESSION['enabled'] = true;
                $this->userModel->enableUserByEmail($_SESSION['email']);
                redirect("home");
            }else{
                $this->view("users/enable_account",$data);
            }
        }
    }
    public function search(){
        $username = $_GET['username'];
    }
    public function deconnection(){
        destroySession();
        redirect("users/login");
    }
}