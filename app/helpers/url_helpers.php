<?php

function redirect($path){
    header("location: " . ROOT . $path);
}
// Compare the url with each link and add the active class on the clicked link
function addClass($link = ''){
    $links = array("pages/features","users/login","users/register");
    if (isset($_GET['url'])){
        $link = strtolower($link);
        $url = strtolower($_GET['url']);
        if (empty($link) && !in_array($url,$links)){
            return "active";
        }elseif ($link === $url){
            return "active";
        }
    }
}