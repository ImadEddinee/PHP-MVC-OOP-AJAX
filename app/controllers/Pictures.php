<?php

class Pictures extends Controller{

    private $pictureModel;
    private $categoryModel;
    public function __construct(){
        if (!isLoggedIn()) {
            redirect("users/login");
        }
        $this->pictureModel = $this->model("Picture");
        $this->categoryModel = $this->model("Category");
    }

    public function index(){

    }

    public function add(){
        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            $data = [
                'title' => 'Home Page',
                'picture_link' => trim($_POST['link']),
                'picture_description' => trim($_POST['description']),
                'categories' => $this->categoryModel->getAllCategories()
            ];
            $fileExt = explode(".",$_FILES['photo']['name']);
            $fileActualExt = strtolower(end($fileExt));
            $allowedExt = array("jpg","jpeg","png");
            if (in_array($fileActualExt,$allowedExt)){
                // Make sure the name of the file is unique
                $fileNewName = uniqid("", true).".".$fileActualExt;
                $fileDestination = 'assets/photos/' . $fileNewName;
                // TODO: add directory for each user
                move_uploaded_file($_FILES['photo']['tmp_name'], $fileDestination);
                // Persist the post
                $photo_id = $this->pictureModel->add_photo($fileDestination,$data['picture_description'],$data['picture_link'])[0]->id;
            }else{
                $data['photo_error'] = "File extension not allowed";
            }
            // Make sure that atleast one category is checked
            if (isset($_POST['categories'])){
                foreach ($_POST['categories'] as $cat){
                    $this->pictureModel->map_picture_category($photo_id, $cat);
                    flash("post_added","Une nouvelle photo a été ajoutée");
                    redirect("home");
                }
            }else{
                $data['checkbox_error'] = "Atleast one category should be chosen";
            }
            if (isset($data['checkbox_error']) || isset($data['photo_error'])){
                $this->view("home/index",$data);
            }
        }

    }
}
