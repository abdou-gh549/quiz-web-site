<?php

class Formateur extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('db_model');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('form');

        if (isset($_SESSION['userPseudo']) && isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && isset($_SESSION['compte_type'])) {
            if( $_SESSION['compte_type'] != 2)
            redirect( base_url() );
           
            $rslt = $this->db_model->checkUserExist($_SESSION['userPseudo'], $_SESSION['compte_type']);

            if (!$rslt || $rslt->userExist != 1 ) { // user does not exist
                //destroyd session
                $this->disconect();
            }

        } else {
            //destroyd session
            $this->disconect();
        }

    }

    public function home()
    {

            $this->loadHomeFormateurPages();

    }

    public function profile(){
        $this->loadProfileFormateurPage();
    }

    public function loadHomeFormateurPages()
    {
        $data['actu'] = $this->db_model->get_all_actualites();
       $this->load->view('template/formateur/formateur_side_bar', array('selectedOption' => 'home'));
       $this->load->view('template/formateur/formateur_home',$data);
       $this->load->view('template/formateur/formateur_bas');

    }

    public function loadProfileFormateurPage() {
        $data = $this->getInformationFromDatabase();
        $this->load->view('template/formateur/formateur_side_bar', array('selectedOption' => 'profile'));
        if($this->session->flashdata('editFail')){
            $data['errorMessage'] = $this->session->flashdata('message');
        }else if( $this->session->flashdata('editSuccess')){
            
            $data['editSuccess'] = true;

        }
        $this->load->view('template/formateur/formateur_profile', $data);
        $this->load->view('template/formateur/formateur_bas');
    }

    private function getInformationFromDatabase()
    {
        $data['compte_information'] = $this->db_model->getUserInformation($_SESSION['userPseudo']);
        return $data;
    }

    public function disconect()
    {
        $this->session->sess_destroy();
        // redirect to Accuiell
        redirect(base_url());
    }

    public function modifierData(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nom', 'Nom', 'required');
        $this->form_validation->set_rules('prenom', 'Prénom', 'required');

        if ($this->form_validation->run() == FALSE)
        {   
            $this->modificationMatchFail("les champs Nom et Prénome sont obligatoires");

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
            $this->session->set_flashdata('editSuccess', true);
            redirect(base_url()."/index.php/formateur/profile");
        }     
        
    
    }


    private function modificationFail($message)
    {

        $this->session->set_flashdata('editFail', true);
        $this->session->set_flashdata('message',$message);
        redirect(base_url()."/index.php/formateur/profile");
    }

    private function newMatchFail($message,$quizID)
    {

        $this->session->set_flashdata('editFail', true);
        $this->session->set_flashdata('message',$message);
        redirect(base_url()."/index.php/formateur/newMatch/".$quizID);
    }
    
    private function modificationMatchFail($message,$matchCode)
    {

        $this->session->set_flashdata('editFail', true);
        $this->session->set_flashdata('message',$message);
        redirect(base_url()."/index.php/formateur/editMatch/".$matchCode);
    }
    public function match(){
        $data['quiz'] = $this->db_model->getActiveQuiz($_SESSION['userPseudo']); 

        $this->load->view('template/formateur/formateur_side_bar', array('selectedOption' => 'match'));
        $this->load->view('template/formateur/formateur_quizForMatch', $data);
        $this->load->view('template/formateur/formateur_bas');
    }

    public function viewMatchOfQuiz($quizId){
        $data['match'] = $this->db_model->getMatchForFormateur($_SESSION['userPseudo'],$quizId); 
        $data['quizId'] = $quizId;

        $this->load->view('template/formateur/formateur_side_bar', array('selectedOption' => 'match'));
        $this->load->view('template/formateur/formateur_allMatch', $data);
        $this->load->view('template/formateur/formateur_bas');
    }

    

    public function viewMatch($matchCode,$quiz){
        $data['match'] = $this->db_model->getOneMatchForFormateur($_SESSION['userPseudo'],$matchCode); 
        $this->load->view('template/formateur/formateur_side_bar', array('selectedOption' => 'match'));
        $this->load->view('template/formateur/formateur_oneMatch', $data);
        
        $data['match'] = $this->db_model->getMatchForFormateur($_SESSION['userPseudo'],$quiz); 
        $data['quizId'] = $quiz;
        $this->load->view('template/formateur/formateur_allMatch', $data);
        $this->load->view('template/formateur/formateur_bas');
    }

    public function quize(){
        $data['quiz'] = $this->db_model->getAllQuize();
        
        $this->load->view('template/formateur/formateur_side_bar', array('selectedOption' => 'quize'));
        $this->load->view('template/formateur/formateur_quize', $data);
        $this->load->view('template/formateur/formateur_bas');
        
    }

    public function removeMatch($matchId)
    {
        $result = $this->db_model->getMatchOwner($matchId);
        if(isset($result['0']) && !strcmp($_SESSION['userPseudo'], $result['0']['cpt_pseudo'])){
            $this->db_model->deleteMatch($matchId);
            echo 1;
        }else{
            echo 0;
        }
    }

    public function newMatch($quizId)
    {
        $data['quizId'] = $quizId;
        if($this->session->flashdata('editFail')){
            $data['errorMessage'] =  $this->session->flashdata('message');
        }
        $this->load->view('template/formateur/formateur_side_bar', array('selectedOption' => 'match'));
        $this->load->view('template/formateur/formateur_newMatch.php',$data);
    

        
    }
    public function newMatchValidation($quizId)
    {
       
        $this->load->library('form_validation');
        $this->form_validation->set_rules('matchIntitule', 'match intitule', 'required');
        $this->form_validation->set_rules('dateDebut', 'dd/mm/yyyy', 'required');
        $this->form_validation->set_rules('dateFin', 'dd/mm/yyyy', 'required');

        if ($this->form_validation->run() == FALSE)
        {   
            $this->newMatchFail("tous les champs sont obligatoires",$quizId);

        }
        else
        {      
            // generat pseudo
            $code = $this->randomString(8);

            while( $this->db_model->checkIfMatchExist($code)[0]['count(*)']){
                $code = $this->randomString(8);

            }   

            // check if date debut valide

            $dateDebut = $this->input->post('dateDebut');
            $dateFin = $this->input->post('dateFin');
         //   date_default_timezone_get();
            $today_dt = new DateTime('now');
            $dateDb = new DateTime($dateDebut);
            $dateFn = new DateTime($dateFin);
            if ($dateDb < $today_dt) { 
                $this->newMatchFail("date début invalide",$quizId);
            }else if($dateFn < $dateDb){
                $this->newMatchFail("date début superieur a la date de fin !",$quizId);
            }
            // insert the new match
            $matchVisibility = $this->input->post('matchVisibility');
            if( $matchVisibility != NULL){
                $matchVisibility = 1;
            }
            $intitul = $this->input->post('matchIntitule');
            

            $this->db_model->insertMatch($_SESSION['userPseudo'],$intitul,$dateDebut,$dateFin,$matchVisibility,$quizId,$code);
            
        }  
        $data['quizId'] = $quizId;
        $data['editSuccess'] = true;
        $this->load->view('template/formateur/formateur_side_bar', array('selectedOption' => 'match'));
        $this->load->view('template/formateur/formateur_newMatch',$data);
        

    }
    public function editMatch($matchCode){
        
        $data['match'] = $this->db_model->getMatch($matchCode);
        
        if($this->session->flashdata('editFail')){
            $data['errorMessage'] =  $this->session->flashdata('message');
        }
        $this->load->view('template/formateur/formateur_side_bar', array('selectedOption' => 'match'));
        $this->load->view('template/formateur/formateur_editMatch',$data);
    }

    public function editMatchValidation($matchCode){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('intitule', 'intitule', 'required');
        $this->form_validation->set_rules('dateDebut', 'jj/mm/aaaa', 'required');
        $this->form_validation->set_rules('heurDebut', '--:--:--', 'required');
        $this->form_validation->set_rules('dateFin', 'jj/mm/aaaa', 'required');
        $this->form_validation->set_rules('heurFin', '--:--:--', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {   
            $this->modificationMatchFail("Veuillez remplir correctement le formulaire",$matchCode);
            
        }
        else
        {       
            
            $dateDebut = $this->input->post('dateDebut')." ".$this->input->post('heurDebut');
            $dateFin = $this->input->post('dateFin')." ".$this->input->post('heurFin');
         //   date_default_timezone_get();
            $today_dt = new DateTime('now');
            $dateDb = new DateTime($dateDebut);
            $dateFn = new DateTime($dateFin);
            if ($dateDb < $today_dt) { 
                $this->modificationMatchFail("date début invalide",$matchCode);
            }else if($dateFn < $dateDb){
                $this->modificationMatchFail("date début superieur a la date de fin !",$matchCode);
            }
            $matchVisibility = $this->input->post('matchVisibility');
            if( $matchVisibility != NULL){
                $matchVisibility = 1;
            }

            $intitul = $this->input->post('intitule');

            $this->db_model->modifierMatch($_SESSION['userPseudo'],$intitul,$dateDebut,$dateFin,$matchVisibility,$matchCode);
            
            $data['editSuccess'] = true;
            $data['match'] = $this->db_model->getMatch($matchCode);
            $this->load->view('template/formateur/formateur_side_bar', array('selectedOption' => 'match'));
            $this->load->view('template/formateur/formateur_editMatch',$data);
        }     
        
    }



    private function randomString($length) {
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }
}

?>