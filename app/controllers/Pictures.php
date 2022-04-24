<?php

class Pictures extends Controller{

    private $pictureModel;
    public function __construct(){
        if (!isLoggedIn()) {
            redirect("users/login");
        }
        $this->pictureModel = $this->model("Picture");
    }

    public function index(){

    }

    public function add(){
        $data = [
            'title' => 'Home Page',
            'picture_link' => '',
            'picture_description' => '',
            'categories' => $this->categoryModel->getAllCategories()
        ];
        if (isset($_POST['categories'])){
            if (!empty($_POST['categories'])){
                $fichier = sauve_photo('photo');
                if ($fichier != null){
                    $picture = $this->loadModel("photo");
                    $categorie = $this->loadModel("category");
                    // Add photo in database
                    if ($picture->add_photo($fichier,$date_photo,$description,$_SESSION['user_name'])){
                        //Get photo id
                        $id_photo = $picture->get_id();
                        $result = array();
                        foreach ($_POST['categories'] as $cat){
                            //Map each photo with its categories
                            $categorie->map_categorie_photo($id_photo[0]->id,$cat);
                            // Get the name of each categorie
                            $result[] = $categorie->get_categorie_by_id($cat)[0];
                        }
                        $date = strtotime($date_photo);
                        $data['photo_info']['prop'] = $_SESSION['user_name'];
                        $data['photo_info']['date'] = date('d/m/Y',$date);
                        $data['photo_info']['desc'] = $description;
                        $data['photo_info']['fichier'] = $fichier;
                        $data['photo_info']['categories'] = $result;
                        $data['page_title'] = "Photo Ajoutée";
                        $this->view("photo/ajout_photo",$data);
                    }
                }else{
                    header("location: ".ROOT);
                }
            }else{
                header("location: ".ROOT);
            }
        }else{
            header("location: ".ROOT);
        }
    }
}
