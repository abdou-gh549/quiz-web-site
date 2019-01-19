<?php
class Db_model extends CI_Model{

    public $salt = "abdellah ghebbache yeah yeah";
    public function __construct(){
        $this->load->database();
    }

    public function get_all_actualites(){
      
        $query = $this->db->query("
        SELECT `act_intitule`,`act_descriptif`,`act_date_debut`,`cpt_pseudo` FROM `actualite` 
        where act_date_debut < NOW() and act_date_fin> NOW() ;
        ");
        return $query->result_array();
    }
    public function get_match_information($matchCode){
        $matchCode = $this->db->escape_str($matchCode);
        $query = $this->db->query("
            SELECT match_intitule, quiz_intitule,quiz_descriptif,quiz_img,qst_id,qst_libelle,qst_ordre,qst_etat,qst_nbPoints,rep_id,qst_id,
            rep_libelle from matchs
            inner join quiz using (quiz_id)
            inner join question using (quiz_id)
            inner join reponse using (qst_id)
            where match_code = '".$matchCode."' order by qst_ordre;
        ");

        return  $query->result_array();
    }
    public function getMatch($matchCode){
        $matchCode = $this->db->escape_str($matchCode);
        $query = $this->db->query("
            SELECT `match_code`, `match_intitule`, `match_situation`, `match_date_debut`, `match_date_fin`, `match_visibility`,`quiz_id`,`cpt_pseudo`
             from matchs
            where match_code = '".$matchCode."'
        ");
        return $query->result_array();
    }

    public function getMatchOwner($matchCode){
        $matchCode = $this->db->escape_str($matchCode);
        $query = $this->db->query("
            SELECT `cpt_pseudo`
             from matchs
            where match_code = '".$matchCode."'
        ");
        return $query->result_array();

    }

    public function checkUserExist($pseudo, $comtpeType){
        $pseudo = $this->db->escape_str($pseudo);
        $comtpeType = $this->db->escape_str($comtpeType);
       

        $query = $this->db->query("
                    SELECT 1 as userExist
                    FROM `compte`
                        WHERE cpt_type = ".$comtpeType." and cpt_pseudo='".$pseudo."';
        ");

        return $query->row();
    }

    public function getUserInformation($pseudo){
        $pseudo = $this->db->escape_str($pseudo);

        $query = $this->db->query("       
                SELECT `cpt_pseudo`, `cpt_nom`, `cpt_prenom`,  `cpt_actif`,`cpt_type`
                FROM compte
                    WHERE cpt_pseudo = '".$pseudo."';
        ");
        return $query->row();
    }

    public function accountExist($userPseudo, $psw)
    {
        $userPseudo = $this->db->escape_str($userPseudo);
        $psw = $this->db->escape_str($psw);
       
         $query = $this->db->query("       
                SELECT 1 
                FROM compte 
                    WHERE cpt_pseudo = '".$userPseudo."' and
                        cpt_mdp = '".hash('sha256', $psw .$this->salt)."'and cpt_actif = 1;
        ");
        return $query->row();
    }

    public function updateUserData($pseudo , $nvNom,$nvPrenom,  $nvPassword){
      
        $this->db->set('cpt_nom', $nvNom);
        $this->db->set('cpt_prenom', $nvPrenom);
        if( ! empty($nvPassword)){
            $hashedpsw = hash('sha256', $nvPassword .$this->salt);
            $this->db->set('cpt_mdp', $hashedpsw);
        }
        $this->db->where('cpt_pseudo', $pseudo);
        $this->db->update('compte');
    }

    public function getMatchForFormateur($pseudo,$quizId){
        $pseudo = $this->db->escape_str($pseudo);
        $quizId = $this->db->escape_str($quizId);

         $query = $this->db->query("
             SELECT match_intitule,match_code,match_date_debut,match_date_fin, quiz_intitule,quiz_descriptif,quiz_img,qst_id,qst_libelle,qst_ordre,qst_etat,qst_nbPoints,
             rep_libelle,rep_valeur from matchs
             inner join quiz using (quiz_id)
             inner join question using (quiz_id)
             inner join reponse using (qst_id)
             where 
                matchs.quiz_id = '".$quizId."';

         ");
 
         return  $query->result_array();   
 }

 public function getOneMatchForFormateur($pseudo,$matchCode){
    $pseudo = $this->db->escape_str($pseudo);
    $matchCode = $this->db->escape_str($matchCode);
    
     $query = $this->db->query("
         SELECT match_intitule,match_code,match_date_debut,match_date_fin,COALESCE(match_score,0) as match_score, quiz_intitule,quiz_descriptif,quiz_img,qst_id,qst_libelle,qst_ordre,qst_etat,qst_nbPoints,
         rep_libelle,rep_valeur from matchs
         inner join quiz using (quiz_id)
         inner join question using (quiz_id)
         inner join reponse using (qst_id)
         inner join (select sum(jou_score)/count(*)as match_score from joueur where match_code ='".$matchCode."')as t on 
         match_code = '".$matchCode."';
     ");

     return  $query->result_array();   
}

    public function getAllAccount()
    {
        $query = $this->db->query("
                SELECT `cpt_pseudo`, `cpt_nom`, `cpt_prenom`, `cpt_type`, `cpt_actif` 
                FROM `compte`;
        ");

        return  $query->result_array();
    }

    public function getAllQuizeOfUser($pseudo)
    {   
        $query = $this->db->query("
                SELECT  quiz_intitule,quiz_descriptif,quiz_img,qst_id,qst_libelle,qst_ordre,qst_etat,qst_nbPoints,
                rep_libelle,rep_valeur from quiz
                inner join question using (quiz_id)
                inner join reponse using (qst_id)
                where cpt_pseudo  = '".$pseudo."';
            
        ");

        return  $query->result_array();
    }

    public function getAllQuize(){
        $query = $this->db->query("
            SELECT `quiz_id`, `quiz_intitule`, `quiz_descriptif`, `quiz_img`, `quiz_etat`, `cpt_pseudo`
            FROM `quiz`;

        ");

        return  $query->result_array();
    }
    /*
    on utilise la procdeure 
        drop procedure IF EXISTS delete_match;
        DELIMITER //
        Create Procedure delete_match (id varchar(8))
        BEGIN
             //removing players 
            delete from joueur 
                where match_code = id;
                
            //removing matchs 
            delete from matchs
                where match_code = id;
             //removing response  
        END;
    */
    public function deleteMatch($matchId){
        $matchId = $this->db->escape_str($matchId);

        $query = $this->db->query('call delete_match("'.$matchId.'")');
    }

    public function getActiveQuiz($compte_pseudo){
        $compte_pseudo = $this->db->escape_str($compte_pseudo);
        /*$query = $this->db->query('        
            Select quiz.quiz_id, quiz.quiz_intitule,quiz.quiz_descriptif,quiz.cpt_pseudo,COALESCE(nombreMatch, 0) as quiz_matchNumber
            from quiz LEFT JOIN (
                        select count(*) AS nombreMatch,match_code,quiz_id,cpt_pseudo
                                FROM matchs where cpt_pseudo = "'.$compte_pseudo.'"
                                GROUP BY quiz_id
                    )as t 
                        on t.quiz_id = quiz.quiz_id and quiz_etat = 1 ORDER BY quiz_matchNumber DESC;
        ');*/
        $query = $this->db->query('        
            Select quiz.quiz_id, quiz.quiz_intitule,quiz.quiz_descriptif,quiz.cpt_pseudo,COALESCE(nombreMatch, 0) as quiz_matchNumber
            from quiz LEFT JOIN (
                        select count(*) AS nombreMatch,match_code,quiz_id,cpt_pseudo
                                FROM matchs 
                                GROUP BY quiz_id
                    )as t 
                        on t.quiz_id = quiz.quiz_id and quiz_etat = 1 ORDER BY quiz_matchNumber DESC;
        ');

        return $query->result_array();
    }

    public function checkIfMatchExist($code)  
    {
        $code = $this->db->escape_str($code);
        $query = $this->db->query('
            Select count(*) 
            from matchs
                where match_code = "'.$code.'"
        '
        );

        return $query->result_array();
    }

    public function insertMatch($comptePseudo, $intitul,$dateDebut,$dateFin,$visibility,$quizId,$matchCode){
        $comptePseudo = $this->db->escape_str($comptePseudo);
        $intitul = $this->db->escape_str($intitul);
        $dateDebut = $this->db->escape_str($dateDebut);
        $dateFin = $this->db->escape_str($dateFin);
        $code = $this->db->escape_str($comptePseudo);
        $visibility = $this->db->escape_str($visibility);
        $quizId = $this->db->escape_str($quizId);

        $query = $this->db->query('
            INSERT INTO `matchs` (`match_code`, `match_intitule`, `match_situation`, `match_date_debut`, `match_date_fin`, `match_visibility`, `cpt_pseudo`, `quiz_id`) 
            VALUES ("'.$matchCode.'", "'.$intitul.'", 1, "'.$dateDebut.'", "'.$dateFin.'", "'.$visibility.'", "'.$comptePseudo.'", '.$quizId.');
        '
        );
    }

    public function modifierMatch($comptePseudo, $intitul,$dateDebut,$dateFin,$visibility,$matchCode){
        $this->db->set('match_intitule', $intitul);
        $this->db->set('match_date_debut', $dateDebut);
        $this->db->set('match_date_fin', $dateFin);
        $this->db->set('match_visibility', $visibility);
        $this->db->where('match_code', $matchCode);
        $this->db->where('cpt_pseudo', $comptePseudo);
        $this->db->update('matchs');
    }
    /*
        Select insert_joueur("sss", "tixx14xx");
        DELIMITER //
        Create Function insert_joueur (jpseudo varchar(50),match_c char(8)) Returns boolean
        BEGIN
            DECLARE joueur_id int(20) DEFAULT -1 ;
            Select joueur.jou_id into joueur_id 
                from joueur
                    where jou_pseudo = jpseudo 
                        and match_code = match_c;

            IF joueur_id = -1 THEN
                Insert into joueur(jou_pseudo,match_code) values(jpseudo, match_c);
                return true;
            ELSE 
                return false;
            END IF;  

        END;


    */

    public function insertJoueur($jouPseudo, $codeMatch){
        $query = $this->db->query('select insert_joueur("'.$jouPseudo.'", "'.$codeMatch.'") as result');
        return $query->result_array();
    }

    public function getAllReponseOfMatch($codeMatch){
        $codeMatch = $this->db->escape_str($codeMatch);
        $query = $this->db->query("
            SELECT rep_id,rep_valeur,qst_id, qst_nbPoints as qst_score from reponse
            inner join question using (qst_id)
            inner join quiz using (quiz_id)
            inner join matchs using (quiz_id)
            where match_code = '".$codeMatch."';
        ");

        return  $query->result_array();
    }
    public function updateJoueurScore($pseudoJoueur, $matchCode, $score){
        $this->db->set('jou_score', $score);
        $this->db->where('jou_pseudo', $pseudoJoueur);
        $this->db->where('match_code', $matchCode);
        $this->db->update('joueur');

    }

    public function getAllMatchQuestionBonReponseIfVisible($matchCode){
        $matchCode = $this->db->escape_str($matchCode);
        $query = $this->db->query("
            SELECT match_intitule, quiz_intitule,quiz_descriptif,quiz_img,qst_id,qst_libelle,qst_ordre,qst_etat,qst_nbPoints,
            rep_libelle,rep_valeur from matchs
            inner join quiz using (quiz_id)
            inner join question using (quiz_id)
            inner join reponse using (qst_id)
            where rep_valeur != 0 AND 
                match_code = '".$matchCode."' AND
                match_visibility = 1;
        ");

        return  $query->result_array();
        
    }

}
/*
trigger
DELIMITER //
CREATE TRIGGER checkCompte BEFORE INSERT 
	ON compte FOR EACH ROW 
	BEGIN
		IF ( NEW.cpt_type > 2 || NEW.cpt_type <1) THEN
		   SET NEW.cpt_type = 2;
		END IF;
	END;
*/
?>

