<?php

class Pages extends Controller{

    public function __construct(){

    }

    public function index(){
        $data['title'] = "Welcome";
        $this->view("pages/index",$data);
    }

    public function features(){
        $data['title'] = "Features";
        $this->view("pages/features",$data);
    }
}
