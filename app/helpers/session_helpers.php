<?php

session_start();

function flash($name = '', $message = '',$class = "alert alert-success text-center fw-light"){
    if (!empty($name)){
        if (!empty($message)){
            if (!empty($_SESSION[$name])){
                unset($_SESSION[$name]);
            }
            if (!empty($_SESSION[$name.'_class'])){
                unset($_SESSION[$name.'_class']);
            }
            $_SESSION[$name] = $message;
            $_SESSION[$name.'_class'] = $class;
        }elseif (!empty($_SESSION[$name]) && !empty($_SESSION[$name."_class"])){
            $class = $_SESSION[$name."_class"];
            echo "<div class='$class' id='msg-flash' role='alert'>".$_SESSION[$name]."</div>";
            unset($_SESSION[$name]);
            unset($_SESSION[$name."_class"]);
        }
    }
}
function createUserSession($user){
    $_SESSION['user_id'] = $user[0]->id;
    $_SESSION['user_email'] = $user[0]->email;
    $_SESSION['username'] = $user[0]->username;
    if (!$user[0]->enabled){
        $_SESSION['enabled'] = false;
    }else{
        $_SESSION['enabled'] = true;
    }
}
function isLoggedIn(){
    if (isset($_SESSION['user_id']))
        return true;
    return false;
}
function destroySession(){
    unset($_SESSION['user_email']);
    unset($_SESSION['user_id']);
    unset($_SESSION['username']);
    session_destroy();
}