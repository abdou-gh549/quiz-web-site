/*--------------------------------------------------------------------------------
1. Requête qui liste toutes les questions d’un quiz particulier dont on connaît l’ID
---------------------------------------------------------------------------------*/

SELECT  qst_id,qst_libelle,qst_ordre,qst_etat,qst_nbPoints,
            from question where quiz_id = $quizID;

/*--------------------------------------------------------------------------------
2. Requête qui ajoute une question à un quiz particulier dont on connaît l’ID
---------------------------------------------------------------------------------*/
INSERT INTO `question` 
        (`qst_id`, `qst_libelle`, `qst_type`, `qst_ordre`, `qst_etat`, `qst_nbPoints`, `quiz_id`) 
        VALUES (NULL, $libelle, $type,$ordre, $etat, $nbPoint, $quizId);

/*----------*/
SELECT  qst_id,qst_libelle,qst_ordre,qst_etat,qst_nbPoints
            from question where quiz_id = $quizID;
            
/*--------------------------------------------------------------------------------
3. Requête qui modifie une question d’un quiz particulier dont on connaît l’ID
---------------------------------------------------------------------------------*/

UPDATE `question` SET `qst_libelle` = $libelle,
                      `qst_etat` = $etat,
                      `qst_nbPoints` = $nbPoint 
                      WHERE `question`.`qst_id` = $qstID;

/*--------------------------------------------------------------------------------
4. Requête qui active (/désactive) une question d’un quiz particulier dont on
connaît l’ID
--------------------------------------------------------------------------------*/
/* desactive*/
UPDATE `question` SET `qst_etat` = 0 WHERE `question`.`qst_id` = $qstID;
/*active*/
UPDATE `question` SET `qst_etat` = 1 WHERE `question`.`qst_id` = $qstID;

/*--------------------------------------------------------------------------------
5. Requête qui supprime une question (+ toutes les données associées) d’unquiz particulier dont on connaît l’ID
------------------------------------------------------------------------------------*/

drop procedure IF EXISTS delete_question;
DELIMITER //
Create Procedure delete_question (id int(20))
BEGIN
    /* removing players */
    delete from repons 
        where qst_id = id;
            
    delete from question 
        where quiz_id = id;
    /* removing quize  */

END;

/*--------------------------------------------------------------------------------
6. Requête qui liste les questions d’un quiz dans l’ordre
------------------------------------------------------------------------------------*/
SELECT  qst_id,qst_libelle,qst_ordre,qst_etat,qst_nbPoints,
            from question where quiz_id = $quizID order by qst_ordre;
/*--------------------------------------------------------------------------------
7. Requête qui modifie le numéro (ordre) d’une question d’un quiz
------------------------------------------------------------------------------------*/

drop procedure IF EXISTS update_ordre;

DELIMITER //
Create Procedure update_ordre (idQuestion int(20), new_ordre int)
BEGIN

    DECLARE id_quize int(20);
    DECLARE qst_current_ordre int(20);

    DECLARE id_qst_cursor int (20);
	DECLARE finCurseur BOOLEAN DEFAULT FALSE ;	
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET finCurseur = TRUE ;

    SELECT quiz_id INTO id_quize FROM question WHERE qst_id = idQuestion;
    SELECT qst_ordre INTO qst_current_ordre FROM question WHERE qst_id = idQuestion;
    
    IF new_ordre > qst_current_ordre THEN 
    BEGIN
        DECLARE curseurQuestionDeQuize CURSOR FOR 
            SELECT qst_id 
                FROM question 
                     where  quiz_id = id_quize and  
                            qst_ordre > qst_current_ordre and
                            new_ordre >= qst_ordre
                     order by qst_ordre;

        OPEN curseurQuestionDeQuize;

            FETCH curseurQuestionDeQuize INTO id_qst_cursor;
            WHILE NOT finCurseur DO
                UPDATE question
                    SET qst_ordre = qst_ordre - 1
                        WHERE qst_id = id_qst_cursor;
                FETCH curseurQuestionDeQuize INTO id_qst_cursor;
            END WHILE;

        CLOSE curseurQuestionDeQuize;

        UPDATE question
            SET qst_ordre = new_ordre
                WHERE qst_id = idQuestion;
    END;

    ELSEIF new_ordre < qst_current_ordre THEN
    BEGIN
         DECLARE curseurQuestionDeQuize CURSOR FOR 
            SELECT qst_id 
                FROM question 
                     where  quiz_id = id_quize and  
                            qst_ordre < qst_current_ordre and
                            qst_ordre >= new_ordre 
                     order by qst_ordre;

        OPEN curseurQuestionDeQuize;

            FETCH curseurQuestionDeQuize INTO id_qst_cursor;
            WHILE NOT finCurseur DO
                UPDATE question
                    SET qst_ordre = qst_ordre + 1
                        WHERE qst_id = id_qst_cursor;
                FETCH curseurQuestionDeQuize INTO id_qst_cursor;
            END WHILE;

        CLOSE curseurQuestionDeQuize;
    
        UPDATE question
            SET qst_ordre = new_ordre
                WHERE qst_id = idQuestion;
    END;
    END IF;
END;


/*--------------------------------------------------------------------------------
8. Requête  qui  liste  tous  les  choix  possibles  pour  une  question  d’un  quizparticulier dont on connaît l’ID
------------------------------------------------------------------------------------*/
SELECT   rep_libelle,rep_valeur from reponse
            inner join question using (qst_id)
            where qst_id= $qstID;

------------------------------------------------------------------------------------*/
/*--------------------------------------------------------------------------------
9. Requête qui donne la (les) bonne(s) réponse(s) pour une question d’un quiz particulier dont on connaît l’ID
------------------------------------------------------------------------------------*/
SELECT   rep_libelle,rep_valeur from reponse
            inner join question using (qst_id)
            where qst_id= $qstID and rep_valeur != 0;

/*--------------------------------------------------------------------------------
10. Requête qui ajoute une proposition de réponse pour une question d’un quiz particulier
------------------------------------------------------------------------------------*/
INSERT INTO `reponse` (`rep_id`, `rep_libelle`, `rep_valeur`, `qst_id`) VALUES (NULL, $libelle, $valeur, $quizId);
/*--------------------------------------------------------------------------------
11. Requête qui modifie une proposition de réponse pour une question d’un quiz particulier
-----------------------------------------------------------------------------------*/
UPDATE `reponse` SET `rep_libelle` = $libelle WHERE `reponse`.`rep_id` = $repID;
UPDATE `reponse` SET `rep_valeur` = $valeur WHERE `reponse`.`rep_id` = $repID;

/*--------------------------------------------------------------------------------
12. Requête qui supprime une proposition de réponse pour une question d‘un
quiz particulier
------------------------------------------------------------------------------------*/
 delete from repons 
        where rep_id = $id;