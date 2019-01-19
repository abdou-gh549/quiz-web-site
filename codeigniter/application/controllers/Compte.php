<?php
class Compte extends CI_Controller{
   
    public function __construct(){
        parent::__construct();
        $this->load->model('db_model');
    }

    private function setUpForme(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('userPseudo', 'Pseudo', 'required');
        $this->form_validation->set_rules('userPassword', 'Password', 'required');
    }
    
    public function connecterFormateur(){
        $this->setUpForme();
        $this->load->library('session');

        if ($this->form_validation->run() == FALSE)
        {   
            $this->loginFail(2, "champ vide !!");
        }
        else
        {
            if($this->input->post('userPseudo') && $this->input->post('userPassword')){

                $result = $this->db_model->accountExist($this->input->post('userPseudo'), $this->input->post('userPassword'));
                if(!$result){
                    // user does not exist
                    $this->loginFail(2, "pseudo ou mot de passe n'existe pas");
                }
    
                $newdata = array(
                    'userPseudo'  => $this->input->post('userPseudo'),
                    'userPassword' =>  $this->input->post('userPassword'),
                    'logged_in' => TRUE,
                    'compte_type' => 2
                );
                $this->session->set_userdata($newdata);
                
                redirect(base_url()."/index.php/formateur/home");
            }
        }        
        
    }
    
    private function loginFail($user, $message){
        $this->session->set_flashdata('loginfail', true);
        $this->session->set_flashdata('user', $user);
        $this->session->set_flashdata('message',$message);
        redirect(base_url()."/index.php/accueil/loginFail");
    }

    public function connecterAdministrateur(){
        $this->setUpForme();
        $this->load->library('session');
        
        if ($this->form_validation->run() == FALSE)
        {
            $this->loginFail(1, "champ vide !!");

        }
        else
        {
            if($this->input->post('userPseudo') && $this->input->post('userPassword')){

                $result = $this->db_model->accountExist($this->input->post('userPseudo'), $this->input->post('userPassword'));
                if(!$result){
                    // user does not exist
                    $this->loginFail(1, "pseudo ou mot de passe n'existe pas");
                }

                $newdata = array(
                    'userPseudo'  => $this->input->post('userPseudo'),
                    'userPassword' =>  $this->input->post('userPassword'),
                    'logged_in' => TRUE,
                    'compte_type' => 1
                );
                $this->session->set_userdata($newdata);
                
                redirect(base_url()."/index.php/administrateur/home");
            }
        }  

    }
}

?>