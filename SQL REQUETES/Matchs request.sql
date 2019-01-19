
/*-------------------------------------------------------------------------
1. Requête vérifiant l’existence (ou non) du code d’un match
-------------------------------------------------------------------------*/
Select count(*) 
    from matchs
        where match_code = "tixx14xx"
/*-------------------------------------------------------------------------

2. Requête d’ajout du pseudo d’un joueur pour un match particulier dont l’ID est
connu
-------------------------------------------------------------------------*/
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
            END IF;  
        ELSE 
             return false;
    END;


/*-------------------------------------------------------------------------
3. Requête(s) d’affichage de toutes les questions (+ réponses) associées à un
match
-------------------------------------------------------------------------*/
/*
# get match question
# $code_match  variable qui contien match code
*/
SELECT `qst_id`,`qst_libelle`,`qst_type`,`qst_ordre`,`qst_etat`,`qst_nbPoints`,`rep_libelle`, `rep_valeur`
    FROM `reponse` 
      INNER JOIN `question` USING(qst_id)
        INNER JOIN quiz USING(quiz_id) 
            INNER JOIN matchs using(quiz_id) where match_code = $code_match;

/*-------------------------------------------------------------------------
4. Requête(s) d’affichage, si autorisé, de toutes les questions d’un match et
leur(s) bonne(s) réponse(s)
-------------------------------------------------------------------------*/
 SELECT match_intitule, quiz_intitule,quiz_descriptif,quiz_img,qst_id,qst_libelle,qst_ordre,qst_etat,qst_nbPoints,
            rep_libelle,rep_valeur from matchs
            inner join quiz using (quiz_id)
            inner join question using (quiz_id)
            inner join reponse using (qst_id)
            where rep_valeur != 0 AND 
                match_code = '".$matchCode."' AND
                 match_visibility = 1;

/*-------------------------------------------------------------------------
5. Requête de vérification d’une réponse donnée par un joueur (bonne ou
mauvaise ?)
-------------------------------------------------------------------------*/
# $idDeReponse 
SELECT 1 from reponse where rep_id = $idDeReponse
    AND rep_valeur = 1;

/*-------------------------------------------------------------------------
6. Requête de mise à jour du score d’un joueur particulier (login connu)
-------------------------------------------------------------------------*/
# $scoreToAdd
# $id_joueur

UPDATE `joueur` SET `jou_score` = `$jou_score` where $jou_id = $id_joueur;

/*-------------------------------------------------------------------------
7. Requête de récupération du score d’un joueur particulier (login connu)
-------------------------------------------------------------------------*/
Select jou_score from joueur where jou_id = $joueur_id;

/*-----------------------------------------------------------------------

Matchs   part 2 :

--------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------
1. Requête listant tous les matchs d’un formateur en particulier (formateur connecté)
--------------------------------------------------------------------------*/
SELECT `match_code`, `match_intitule`, `match_situation`, `match_date_debut`,
        `match_date_fin`, `match_visibility`, `quiz_id`
        FROM `matchs`
            WHERE cpt_pseudo = $pseudo;
/*-----------------------------------------------------------------------
2. Requête qui récupère tous les matchs associés à un quiz particulier (connaissant son ID)
--------------------------------------------------------------------------*/

SELECT `match_code`, `match_intitule`, `match_situation`, `match_date_debut`,
        `match_date_fin`, `match_visibility`, `cpt_pseudo`
        FROM `matchs` 
            WHERE quiz_id = $quizId;
/*-----------------------------------------------------------------------
3. Requête d’ajout d’un match pour un quiz particulier (connaissant son ID)
--------------------------------------------------------------------------*/
INSERT INTO `matchs` (`match_code`, `match_intitule`, `match_situation`, `match_date_debut`, `match_date_fin`, `match_visibility`, `cpt_pseudo`, `quiz_id`) 
    VALUES ('', $intitule, $situation, $dateDebut, $dateFin, $visibility, $pseudo, $quizId);
/*-----------------------------------------------------------------------
4. Requête de modification d’un match
--------------------------------------------------------------------------*/
UPDATE `matchs` SET `match_intitule`= $match_intitule ,
                    `match_date_debut` = $matchDateDebut ,
                    `match_date_fin` = $matchDateFin ,
                    `match_visibility` = $visibility WHERE `matchs`.`match_code` = $matchCode;

/*-----------------------------------------------------------------------
5. Requête de suppression d’un match dont on connaît l’ID (/le code)
--------------------------------------------------------------------------*/

drop procedure IF EXISTS delete_match;
DELIMITER //
Create Procedure delete_match (id varchar(8))
BEGIN
    /* removing players */
    delete from joueur 
        where match_code = id;
           
    /* removing matchs */
    delete from matchs
         where match_code = id;
    /* removing response  */
END;
/*-----------------------------------------------------------------------
6. Requête d’activation (/désactivation) d’un match
--------------------------------------------------------------------------*/
/* activaation */
UPDATE `matchs` SET `match_situation` = 1 WHERE `matchs`.`match_code` = $matchCode;
/*désactivation*/
UPDATE `matchs` SET `match_situation` = 0 WHERE `matchs`.`match_code` = $matchCode;

/*-----------------------------------------------------------------------
7. Requête(s) de « remise à zéro » (RAZ) d’un match
--------------------------------------------------------------------------*/
delete from joueur where match_code = "tixx14xx"
/*-----------------------------------------------------------------------
8. Requête(s)  permettant de récupérer toutes les données  (questions, choix possibles) d’un questionnaire associé à un match dont on connaît le code
--------------------------------------------------------------------------*/

SELECT  qst_id,qst_libelle,qst_ordre,qst_etat,qst_nbPoints,
            rep_libelle,rep_valeur from reponse
            inner join question using (qst_id)
            inner join quiz using (quiz_id)
            inner join matchs using(quiz_id)
            where match_code = $codeMatch;

/*-----------------------------------------------------------------------
9. Requête permettant de donner le score final d’un match particulier
--------------------------------------------------------------------------*/
Select sum(jou_score) from joueur
        where match_code = $matchCode;;
/*-----------------------------------------------------------------------
10. Requête listant les scores finaux et les pseudos des joueurs d’un matchparticulier
--------------------------------------------------------------------------*/
Select jou_pseudo, jou_score from joueur 
        where match_code = $matchCode;;