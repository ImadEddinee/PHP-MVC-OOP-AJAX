<?php

class Pictures extends Controller
{

    private $pictureModel;
    private $categoryModel;
    private $commentModel;
    private $userModel;

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect("users/login");
        }
        $this->pictureModel = $this->model("Picture");
        $this->categoryModel = $this->model("Category");
        $this->commentModel = $this->model("Comment");
        $this->userModel = $this->model("User");
    }

    public function index()
    {

    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $data = [
                'title' => 'Home Page',
                'picture_description' => trim($_POST['description']),
                'checked_categories' => isset($_POST['categories']) ? $_POST['categories'] : array(),
                'categories' => $this->categoryModel->getUserCategory($_SESSION['user_id'])
            ];

            $fileExt = explode(".", $_FILES['photo']['name']);
            $fileActualExt = strtolower(end($fileExt));
            $allowedExt = array("jpg", "jpeg", "png");
            if ($_FILES['photo']['size'] != 0) {
                if ($_FILES['photo']['size'] < 5000000) {
                    if (in_array($fileActualExt, $allowedExt)) {
                        // Make sure the name of the file is unique
                        $fileNewName = uniqid("", true) . "." . $fileActualExt;
                        $fileDestination = 'assets/photos/' . $fileNewName;
                        // TODO: add directory for each user
                        move_uploaded_file($_FILES['photo']['tmp_name'], $fileDestination);
                        // Persist the post
                        $photo_id = $this->pictureModel->add_photo($fileDestination, $data['picture_description'])[0]->id;
                    } else {
                        $data['photo_error'] = "File extension not allowed";
                    }
                } else {
                    $data['photo_error'] = "File size is too big";
                }
            } else {
                $data['photo_error'] = "You need to add a picture";
            }
            if (!strlen($data['picture_description']) < 10) {
            } else {
                $data['description_error'] = "Description should atleast contain 10 characters";
            }

            // Make sure that atleast one category is checked
            if (isset($_POST['categories'])) {
                if (!isset($data['photo_error']) && !isset($data['description_error'])) {
                    foreach ($_POST['categories'] as $cat) {
                        $this->pictureModel->map_picture_category($photo_id, $cat);
                        flash("post_added", "Une nouvelle photo a été ajoutée");
                        redirect("home");
                    }
                }
            } else {
                $data['checkbox_error'] = "Atleast one category should be chosen";
            }
            if (isset($data['checkbox_error']) || isset($data['photo_error']) || isset($data['description_error'])) {
                $this->view("home/index", $data);
            }
        }
    }

    public function get($post_id)
    {
        // Get post by id
        $post = $this->pictureModel->getPost($post_id)[0];
        // Get Post's categories
        $categories = $this->pictureModel->findPostCategory($post_id);
        if (!$post || !$categories) {
            die("Post id not found");
        }
        $data = [
            'title' => "Post details",
            'post' => $post,
            'username' => $this->userModel->getUser($post->user_id)[0]->username
        ];
        // Get Category By Id
        foreach ($categories as $cat) {
            $data['categories'][] = $this->categoryModel->getCategoryById($cat->category_id);
        }
        // Get all comments for this post
        if ($comments = $this->commentModel->findCommentsByPostId($post_id)){
            foreach ($comments as $comment){
                $comment->username = $this->userModel->getUser($comment->user_id)[0]->username;
                $data['comments'][] = $comment;
            }
        }

        $this->view("pictures/index", $data);
    }

    public function update($post_id)
    {
        // Check if the user is the owner of the post
        $post = $this->pictureModel->getPost($post_id)[0];
        if (!$post) {
            // TODO : handle exceptions
            die("There is no post with this id");
        }
        if ($post->user_id == $_SESSION['user_id']) {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                // Get all user's categories
                $categories = $this->categoryModel->getUserCategory($_SESSION['user_id']);
                // Get all categories that are relevant to the post
                $postCategories = $this->pictureModel->findPostCategory($post_id);
                foreach ($postCategories as $cat) {
                    $result[] = $this->categoryModel->getCategoryById($cat->category_id);
                }
                foreach ($result as $cat_id) {
                    $category_id[] = $cat_id[0]->id;
                }
                $data = [
                    'title' => "Update Post",
                    'post' => $post,
                    'post_categories' => $category_id,
                    'categories' => $categories
                ];
                $this->view("pictures/update", $data);
            } else {
                $description = trim($_POST['description']);
                if (isset($_POST['categories'])) {
                    $this->categoryModel->deleteCategories($post_id);
                    foreach ($_POST['categories'] as $cat) {
                        //Map each photo with its categories
                        $this->pictureModel->map_picture_category($post_id, $cat);
                    }
                    $this->pictureModel->update_post($description, $post_id);
                    redirect("pictures/get/".$post_id);
                }
            }
        }
    }

    public function delete($post_id){
        // Check if the user is the owner of the post
        $post = $this->pictureModel->getPost($post_id)[0];
        if (!$post) {
            // TODO : handle exceptions
            die("There is no post with this id");
        }
        if ($_SESSION['user_id'] == $post->user_id){
            $this->pictureModel->deletePost($post_id);
            redirect("users");
        }else{
            die("You are not the owner of this post");
        }
    }

    public function vote($post_id,$op){
        // Check if post exists
        $post = $this->pictureModel->getPost($post_id);
        if ($post){
            // if user has already liked the post
            // then decrement the like counter
            // otherwise increment the like counter
            $result = $this->pictureModel->mapUserPost($post_id, $_SESSION['user_id']);
            if ($result){
                if ($op == 1){
                    if ($result[0]->liked){
                        $this->pictureModel->decrementLikes($post_id);
                        $this->pictureModel->deleteReaction($post_id, $_SESSION['user_id']);
                    }else{
                        $this->pictureModel->incrementLikes($post_id);
                        $this->pictureModel->decrementDislikes($post_id);
                        $this->pictureModel->deleteReaction($post_id, $_SESSION['user_id']);
                        $this->pictureModel->mapUserPost($post_id, $_SESSION['user_id'],$op);
                    }
                }else{
                    if ($result[0]->disliked){
                        $this->pictureModel->decrementDislikes($post_id);
                        $this->pictureModel->deleteReaction($post_id, $_SESSION['user_id']);
                    }else{
                        $this->pictureModel->decrementLikes($post_id);
                        $this->pictureModel->incrementDislikes($post_id);
                        $this->pictureModel->deleteReaction($post_id, $_SESSION['user_id']);
                        $this->pictureModel->mapUserPost($post_id, $_SESSION['user_id'],$op);
                    }
                }
            }else{
                $this->pictureModel->mapUserPost($post_id, $_SESSION['user_id'],$op);
                if ($op == 1){
                    $this->pictureModel->incrementLikes($post_id);
                }else{
                    $this->pictureModel->incrementDislikes($post_id);
                }
            }
            redirect("pictures/get/".$post_id);
        }else{
            // Post doesn't exists then return to the home page
            redirect("home");
        }
    }
}
