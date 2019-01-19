<?php
class Administrateur extends CI_Controller{
   
    public function __construct(){
        parent::__construct();
        $this->load->model('db_model');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('form');


        if (isset($_SESSION['userPseudo']) && isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && isset($_SESSION['compte_type'])) {
            if( $_SESSION['compte_type'] != 1)
                redirect( base_url() );

            $rslt = $this->db_model->checkUserExist($_SESSION['userPseudo'], $_SESSION['compte_type']);

            if (!$rslt || $rslt->userExist != 1) { // user does not exist
                //destroyd session
                $this->disconect();
            }

        } else {
            //destroyd session
            $this->disconect();
        }

    }

    public function home(){
        $this->loadHomeAdministrateurPages();

    }

    public function loadHomeAdministrateurPages(){
       $data['actu'] = $this->db_model->get_all_actualites();
       $this->load->view('template/administrateur/administrateur_side_bar', array('selectedOption' => 'home'));
       $this->load->view('template/administrateur/administrateur_home',$data);
       $this->load->view('template/administrateur/administrateur_bas');
    }
    public function profile(){
        $this->loadProfileAdministrateurPage();
    }

    public function loadProfileAdministrateurPage() {
        $data = $this->getInformationFromDatabase();
        $this->load->view('template/administrateur/administrateur_side_bar', array('selectedOption' => 'profile'));
        if($this->session->flashdata('editFail')){
            $data['errorMessage'] = $this->session->flashdata('message');
        }else if( $this->session->flashdata('editSuccess')){
            
            $data['editSuccess'] = true;

        }
        $this->load->view('template/administrateur/administrateur_profile', $data);
        $this->load->view('template/administrateur/administrateur_bas');
    }

    private function getInformationFromDatabase()
    {
        $data['compte_information'] = $this->db_model->getUserInformation($_SESSION['userPseudo']);
        return $data;
    }

    public function modifierData(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nom', 'Nom', 'required');
        $this->form_validation->set_rules('prenom', 'Prénom', 'required');

        if ($this->form_validation->run() == FALSE)
        {   
            $this->modificationFail("les champs Nom et Prénome sont obligatoires");

        }
        else
        {       
            $psw = '';
            if(! empty($this->input->post('new_password'))){
                // changing password case
                // 1 check if password match
                if(strcmp($this->input->post('new_password'), $this->input->post('confirmation_password'))){
                    // password doesn't match 
                    $this->modificationFail("les champs Nouveau mot de passe et Confirmation de mot de passe ne sont pas égaux !!");
                }
                // else password match :)

                $psw = $this->input->post('new_password');
            }
            $nom = $this->input->post('nom');
            $premom = $this->input->post('prenom');
            $this->db_model->updateUserData($_SESSION['userPseudo'],$nom,$premom,$psw);
            $this->session->set_flashdata('editSuccess',true);

            redirect(base_url()."/index.php/administrateur/profile");
        }

    }   

    private function modificationFail($message)
    {

        $this->session->set_flashdata('editFail', true);
        $this->session->set_flashdata('message',$message);
        redirect(base_url()."/index.php/administrateur/profile");
    }    
    public function disconect()
    {
        $this->session->sess_destroy();
        // redirect to Accuiell
        redirect(base_url());
    }
    
    public function comptes()
    {
        $data['comptes'] = $this->db_model->getAllAccount();
        $this->load->view('template/administrateur/administrateur_side_bar',array('selectedOption' => 'comptes'));
        $this->load->view('template/administrateur/administrateur_comptes', $data);
        $this->load->view('template/administrateur/administrateur_bas');
    }


}
    

?>