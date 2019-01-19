<?php
class Match extends CI_Controller{
   
    public function __construct(){
        parent::__construct();
        $this->load->model('db_model');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->library('form_validation');

    }
    
    public function verifierExistanceDeMatch($codeMatch){
        if(!isset($codeMatch)){
            redirect(base_url());
        }
        
        $match = $this->db_model->getMatch($codeMatch);
        
        switch($this->checkMatch($codeMatch)){
            case 0:
                echo "error match not exist";
            break;
            case -1:
                $dateDb = new DateTime($match['0']['match_date_debut']);

                echo "match n'a pas encore commancé\n";
                echo " le match commencera le ".$dateDb->format('Y-m-d H:i:s');
            break;
            case -2:
                $dateFn = new DateTime($match['0']['match_date_fin']);
                echo "le match n'est plus disponible<br>";
                echo "dernier date de disponibilité = ";
                echo $dateFn->format('Y-m-d H:i:s');

            break;
            case 1:
                echo 1;
            break;
        }
    }

    public function choixNomJoueur($codeMatch){
        if($this->checkMatch($codeMatch) != 1){
            redirect(base_url());
        }
        
        $this->load->view('template/match/choix_nom_joueur');
    }

    private function checkMatch($codeMatch){
        $match = $this->db_model->getMatch($codeMatch);
        
        if(!isset($match['0'])){
            return 0;
        }
        $today_dt = new DateTime('now');
        $dateDb = new DateTime($match['0']['match_date_debut']);
        if($today_dt < $dateDb){
            return-1;
        }

        $dateFn = new DateTime($match['0']['match_date_fin']);
        if($today_dt > $dateFn){
            return-2;
        }

        return 1;
    }

    public function joueurPseudoValidation(){
        $pseudo = $this->input->post('pseudoJoueur');
        $codeMatch =  $this->input->post('matchCode');
        
        $result = $this->db_model->insertJoueur($pseudo,$codeMatch);
        if($result['0']['result']){
            $this->session->set_flashdata('pseudoJoueur', $pseudo);
            $this->session->set_flashdata('matchJoueur', $codeMatch);
        }
        echo $result['0']['result'];
       
    }

    public function startMatch(){
        $pseudo = $this->session->flashdata('pseudoJoueur');
        $match = $this->session->flashdata('matchJoueur');
        if(!isset($pseudo) || !isset($match)){
            redirect(base_url());
        }
        
        $this->session->set_flashdata('pseudoJoueur', $pseudo);
        $this->session->set_flashdata('matchJoueur', $match);
        $data['match'] = $this->db_model->get_match_information($match);
        $this->load->view('template/match/page_match', $data);


    }

    public function matchTerminier(){
        
        $this->load->library('form_validation');
        $pseudo = $this->session->flashdata('pseudoJoueur');
        $match = $this->session->flashdata('matchJoueur');

        $allReponse = $this->db_model->getAllReponseOfMatch($match);
        if(empty($allReponse)){
            echo "<h1>Access opération non autorisée !!</h1>";
            echo "<h1><a href='";
            echo base_url();
            echo "'> Accueil</a></h1>";
            
            
            return;
        }
        
        $jouScore = array();
        foreach ($allReponse as $row) {
            $jouRep = $this->input->post($row['rep_id']);
            if(isset($jouRep)){
                if(isset ($jouScore[$row['qst_id']] )){
                    if($jouScore[$row['qst_id']] > 0 && $row['rep_valeur'] == 0){
                        $jouScore[$row['qst_id']] = 0;
                    }
                }else{
                    $jouScore[$row['qst_id']] = $row['qst_score']; 
                }
            }else{
                if($row['rep_valeur'] == 1){
                    $jouScore[$row['qst_id']] = 0;
                }
            }
        }
         
        $nbreDesBonReponse = 0;
        $nbrRep = 0;
        $scoreFinalDesQustion = 0;
        foreach($jouScore as $row){
            $nbrRep++;
            if( $row > 0){
                $scoreFinalDesQustion+=$row;
                $nbreDesBonReponse++;
            }
        }
        $data['joueurPseudo'] = $pseudo;
        $data['nombreDesBonnesReponse'] = $nbreDesBonReponse;
        $data['nombreDesQuestion'] = $nbrRep;
        $data['scoreFinalDesQustion'] = $scoreFinalDesQustion;
        $data['pourcentageDesReponse'] = ($nbreDesBonReponse / $nbrRep) * 100;

        $this->db_model->updateJoueurScore($pseudo,$match, $scoreFinalDesQustion);
        $data['match'] = $this->db_model->getAllMatchQuestionBonReponseIfVisible($match);
        $this->load->view('template/match/affichage_score_match', $data);
    }
}

?>