<?php
class Accueil extends CI_Controller{
   
    public function __construct(){
        parent::__construct();
        $this->load->model('db_model');
        $this->load->helper('form');
        $this->load->library('session');

        // check if there is an existing session 

        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']){
            if(isset($_SESSION['compte_type']) && $_SESSION['compte_type'] == 2){
                redirect(base_url()."/index.php/formateur/home");
            }else if(isset($_SESSION['compte_type']) && $_SESSION['compte_type'] == 1){
                redirect(base_url()."/index.php/administrateur/home");
            }
        }

    }
    
    public function afficher(){
        
        $this->load->helper('form');
        
        $data['actu'] = $this->db_model->get_all_actualites();
        
        $loginVisibility['isVisible'] = false;
        $this->load->view('template/haut');
        $this->load->view('template/page_accueil',$data);
        $this->load->view('template/login_formateur',$loginVisibility);
        $this->load->view('template/login_adminstrateur',$loginVisibility);
        $this->load->view('template/bas');
    }
    


    public function loginFail(){

        // check if there is an existing session 
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']){
            if(isset($_SESSION['compte_type']) && $_SESSION['compte_type'] == 2){
                redirect(base_url()."/index.php/formateur/home");
            }else if ((isset($_SESSION['compte_type']) && $_SESSION['compte_type'] == 1)){
                redirect(base_url()."/index.php/administrateur/home");
            }
        }

        $data['actu'] = $this->db_model->get_all_actualites();
        $this->load->view('template/haut');
        $this->load->view('template/page_accueil',$data);

        if( $this->session->flashdata('loginfail') ){
            $userType = $this->session->flashdata('user');
            if($userType == 1){ // admin
                $loginData['isVisibleAdmin'] = true;
                $loginData['errorMessageAdmin'] = $this->session->flashdata('message');
                $this->load->view('template/login_adminstrateur',$loginData);
                $this->load->view('template/login_formateur',array('isVisibleFormateur'=>false));


            }
            else if($userType == 2) {// formateur
                $loginData['isVisibleFormateur'] = true;
                $loginData['errorMessageFormateur'] = $this->session->flashdata('message');
                $this->load->view('template/login_formateur',$loginData);
                $this->load->view('template/login_adminstrateur',array('isVisibleAdmin'=>false));
            }
        }else{
            $this->load->view('template/login_formateur',array('isVisibleFormateur', false));
            $this->load->view('template/login_adminstrateur',array('isVisibleAdmin', false));
        }
        $this->load->view('template/bas');

                
    }


    


}

?>