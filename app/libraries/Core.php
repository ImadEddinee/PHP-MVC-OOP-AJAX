<?php
/*
 * App core class
 * Breaks the URL in this format controller/method/params
*/
class Core{
    protected $current_controller = "Pages";
    protected $current_method = "index";
    protected $params = [];

    public function __construct(){
        $url = $this->get_url();
        //check if the controller requested exists
        if (isset($url[0])){
            if (file_exists('../app/controllers/'.ucwords($url[0]).'.php')){
                $this->current_controller = ucwords($url[0]);
                unset($url[0]);
            }
        }
        //Require the controller
        require_once '../app/controllers/'.$this->current_controller.".php";
        //Instantiate the controller
        $this->current_controller = new $this->current_controller;
        if (isset($url[1])){
            //check if the method exists
            if (method_exists($this->current_controller,strtolower($url[1]))){
                $this->current_method = strtolower($url[1]);
                unset($url[1]);
            }
        }
        //Take what is left in the url as method params
        $this->params = $url ? array_values($url) : [];
        //Call the method and pass params
        call_user_func_array([$this->current_controller,$this->current_method],$this->params);
    }

    public function get_url(){
        if (isset($_GET['url'])){
            $url = rtrim($_GET['url'],'/');
            $url = filter_var($url,FILTER_SANITIZE_URL);
            $url = explode('/',$url);
            return $url;
        }
    }
}