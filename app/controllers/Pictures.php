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

    public function get($post_id){
        // Get post by id
        $post = $this->pictureModel->getPost($post_id)[0];
        // Get Post's categories
        $categories = $this->pictureModel->findPostCategory($post_id);
        if (!$post_id || !$categories){
            die("Post id not found");
        }
        $data = [
            'title' => "Post details",
            'post' => $post
        ];
        // Get Category By Id
        foreach ($categories as $cat){
            $data['categories'][] = $this->categoryModel->getCategoryById($cat->category_id);
        }
        $this->view("pictures/index",$data);
    }

    public function update($post_id){
        // Check if the user is the owner of the post
        $post = $this->pictureModel->getPost($post_id)[0];
        // Get all user's categories
        $categories = $this->categoryModel->getAllCategories();
        // Get all categories that are relevant to the post
        $postCategories = $this->pictureModel->findPostCategory($post_id);
        foreach ($postCategories as $cat){
            $result[] = $this->categoryModel->getCategoryById($cat->category_id);
        }
        foreach ($result as $cat_id){
            $category_id[] = $cat_id[0]->id;
        }
        if (!$post){
            // TODO : handle exceptions
            die("There is no post with this id");
        }
        if ($_SESSION['user_id'] != $post->user_id ){
            die("You can't modify this post");
        }
        $data = [
            'title' => "Update Post",
            'post' => $post,
            'post_categories' => $category_id,
            'categories' => $categories
        ];
        $this->view("pictures/update",$data);
    }
}
