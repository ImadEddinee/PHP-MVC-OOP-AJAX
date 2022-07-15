<?php

class Comments extends Controller{

    private $commentsModel;
    private $pictureModel;

    public function __construct(){
        $this->commentsModel = $this->model("Comment");
        $this->pictureModel = $this->model("Picture");
    }

    public function index(){

    }

    public function add($post_id){
        $contenu = trim($_POST['contenu']);
        // Get post by id
        $post = $this->pictureModel->getPost($post_id);
        if (!$post){
            die("Post doesn't exists");
        }
        $this->commentsModel->addComment($contenu, $post_id);
        redirect("pictures/get/".$post_id);
    }

    public function delete($comment_id){
        // check if the usr is the owner of the comment
        $comment = $this->commentsModel->getComment($comment_id);
        if (!$comment){
            die("comment id doesn't exists");
        }
        if ($comment[0]->user_id == $_SESSION['user_id']) {
            $this->commentsModel->deleteComment($comment_id);
            redirect("pictures/get/" . $comment[0]->picture_id);
        }
    }
};