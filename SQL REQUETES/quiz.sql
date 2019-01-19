
/*------------------------------------------------------------------------
1. Requête listant tous les quiz
-------------------------------------------------------------------------*/

SELECT `quiz_id`, `quiz_intitule`, `quiz_descriptif`, `quiz_img`, `quiz_etat`, `cpt_pseudo`
     FROM `quiz`;

/* select active quiz avec nombre des match d'un formateur*/

Select quiz.quiz_id, quiz.quiz_intitule,quiz.quiz_descriptif,quiz.cpt_pseudo,COALESCE(nombreMatch, 0) as quiz_matchNumber
    from quiz LEFT JOIN (
                select count(*) AS nombreMatch,quiz_id
                     FROM matchs where cpt_pseudo = $compte_pseudo
                        GROUP BY quiz_id
            )as t 
                on t.quiz_id = quiz.quiz_id and quiz_etat = 1  
                
/*------------------------------------------------------------------------
2. Requête listant tous les quiz d’un formateur en particulier (dont on connaîtl’ID)
-------------------------------------------------------------------------*/
/*  var 
    $pseudo 
*/

SELECT `quiz_id`, `quiz_intitule`, `quiz_descriptif`, `quiz_img`, `quiz_etat`, `cpt_pseudo`
     FROM `quiz` 
        WHERE cpt_pseudo = $pseudo;

/*------------------------------------------------------------------------
3. Requête donnant tous les quiz qui ne sont plus associés à un formateur
-------------------------------------------------------------------------*/
/*  var 
    $pseudo 
*/

SELECT `quiz_id`, `quiz_intitule`, `quiz_descriptif`, `quiz_img`, `quiz_etat`, `cpt_pseudo`
     FROM `quiz` 
        WHERE cpt_pseudo != $pseudo;

/*------------------------------------------------------------------------

4. Requête listant, pour un formateur dont on connaît le login, tous les quiz etleurs matchs, s’il y en a

-------------------------------------------------------------------------*/

SELECT `match_code`, `match_intitule`, `match_situation`, `match_date_debut`, `match_date_fin`, `match_visibility`, quiz.cpt_pseudo, `quiz_id`, `quiz_intitule`, `quiz_descriptif`, `quiz_img`, `quiz_etat`
    FROM `matchs`
    RIGHT JOIN `quiz` using (quiz_id) WHERE quiz.cpt_pseudo = $pseudo;

/*------------------------------------------------------------------------
5. Requête d’insertion d’un quiz
-------------------------------------------------------------------------*/
INSERT INTO `quiz` (`quiz_id`, `quiz_intitule`, `quiz_descriptif`, `quiz_img`, `quiz_etat`, `cpt_pseudo`) 
    VALUES (NULL, 'tst', 'tst', '', '1', 'pseudo');

/*------------------------------------------------------------------------
6. Requête(s) de suppression d’un quiz et de toutes les données qui lui sontassociées
-------------------------------------------------------------------------*/

drop procedure IF EXISTS delete_quize;
DELIMITER //
Create Procedure delete_quize (id int(20))
BEGIN
    /* removing players */
    delete from joueur 
        where match_code 
            in (
                select match_code 
                    from matchs 
                        where quiz_id = id
                );
    /* removing matchs */
    delete from matchs
         where quiz_id = id;
    /* removing response  */

    delete from reponse 
        where qst_id 
            in (
                select qst_id 
                    from question 
                        where quiz_id = id
                );
    /* removing question  */

    delete from question 
        where quiz_id = id;
    /* removing quize  */

    delete from quiz  
        where quiz_id = id ;
END;



/*------------------------------------------------------------------------
7. Requête d’activation (/de désactivation) d’un quiz
-------------------------------------------------------------------------*/

UPDATE `quiz` SET `quiz_etat` = '0' WHERE `quiz`.`quiz_id` = $quizID;

/*------------------------------------------------------------------------
8. Requête(s) de copie d’un quiz
-------------------------------------------------------------------------*/

drop procedure IF EXISTS copier_quize;

DELIMITER //
CREATE Procedure copier_quize(originalQuizeId int(20), user_pseudo varchar(25))
BEGIN

    DECLARE newQuizeID int(20);
    DECLARE questionID int(20);
    DECLARE newQuestionID int(20);

    DECLARE finCurseur BOOLEAN DEFAULT false;

    DECLARE allOriginalQuizQuestionIdCursor CURSOR FOR
        select qst_id 
            from question 
                where quiz_id = originalQuizeId;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET finCurseur = TRUE ;

    /* #copy quiz and add it as new quiz with new pseudo 
    `quiz_id`, `quiz_intitule`, `quiz_descriptif`, `quiz_img`, `quiz_etat`, `cpt_pseudo`
    */
    CREATE TEMPORARY TABLE tmptable_1 SELECT `quiz_intitule`, `quiz_descriptif`, `quiz_img`, `quiz_etat`, `cpt_pseudo`
         FROM quiz WHERE quiz_id = originalQuizeId;
    UPDATE tmptable_1 SET cpt_pseudo = user_pseudo;
    INSERT INTO quiz(`quiz_intitule`, `quiz_descriptif`, `quiz_img`, `quiz_etat`, `cpt_pseudo`)  SELECT `quiz_intitule`, `quiz_descriptif`, `quiz_img`, `quiz_etat`, `cpt_pseudo` FROM tmptable_1;
    DROP TEMPORARY TABLE IF EXISTS tmptable_1;

  /*  # get new quiz id */
    select new_q.quiz_id into newQuizeID 
        from quiz new_q
        inner join quiz old_q 
            on new_q.quiz_intitule = old_q.quiz_intitule COLLATE utf8_unicode_ci  and
            new_q.quiz_descriptif = old_q.quiz_descriptif COLLATE utf8_unicode_ci and
            new_q.quiz_img = old_q.quiz_img COLLATE utf8_unicode_ci and
            new_q.cpt_pseudo = user_pseudo COLLATE utf8_unicode_ci 
            order by quiz_id DESC LIMIT 1;
    /* # copy all question of originale quize */
    
    
    OPEN allOriginalQuizQuestionIdCursor;
    FETCH allOriginalQuizQuestionIdCursor INTO questionID;

    WHILE NOT finCurseur DO
      /*  #COPY QUESTION INFORMATION*/
        CREATE TEMPORARY TABLE tmptable_1 SELECT  `qst_libelle`, `qst_type`, `qst_ordre`, `qst_etat`, `qst_nbPoints`, `quiz_id` FROM question WHERE qst_id = questionID;
        UPDATE tmptable_1 SET quiz_id = newQuizeID;
        INSERT INTO question(`qst_libelle`, `qst_type`, `qst_ordre`, `qst_etat`, `qst_nbPoints`, `quiz_id`) SELECT `qst_libelle`, `qst_type`, `qst_ordre`, `qst_etat`, `qst_nbPoints`, `quiz_id` FROM tmptable_1;
        DROP TEMPORARY TABLE IF EXISTS tmptable_1;

        /*# get new question id */
        select new_q.qst_id into newQuestionID 
            from question new_q
            inner join question old_q 
                on new_q.qst_libelle = old_q.qst_libelle COLLATE utf8_unicode_ci and
                new_q.qst_type = old_q.qst_type and
                new_q.qst_ordre = old_q.qst_ordre and
                new_q.qst_etat = old_q.qst_etat and
                new_q.qst_nbPoints = old_q.qst_nbPoints and
                new_q.quiz_id = newQuizeID
                order by qst_id DESC LIMIT 1;
       /* #copy reponse*/
        CREATE TEMPORARY TABLE tmptable_1 SELECT `rep_libelle`, `rep_valeur`, `qst_id` FROM reponse WHERE qst_id = questionID;
        UPDATE tmptable_1 SET qst_id =  newQuestionID;
        INSERT INTO reponse(`rep_libelle`, `rep_valeur`, `qst_id`) SELECT `rep_libelle`, `rep_valeur`, `qst_id` FROM tmptable_1;
        DROP TEMPORARY TABLE IF EXISTS tmptable_1;
                
        FETCH allOriginalQuizQuestionIdCursor INTO questionID;
    END WHILE;
    CLOSE allOriginalQuizQuestionIdCursor;
    
End;




/*------------------------------------------------------------------------
9. Requête(s) de modification d’un quiz dont on connaît l’ID (+ suppression des matchs associés)
-------------------------------------------------------------------------*/


UPDATE `quiz` SET `quiz_etat` = '0' ,
            `quiz_intitule` = $intutile ,
            `quiz_descriptif` = $descriptif ,
            `quiz_img` = $img WHERE `quiz`.`quiz_id` = $quizID;

/*------------------------------------------------------------------------
10. Requête(s) permettant de récupérer toutes les données (questions, choix possibles) d’un quiz en particulier
-------------------------------------------------------------------------*/

SELECT  quiz_intitule,quiz_descriptif,quiz_img,qst_id,qst_libelle,qst_ordre,qst_etat,qst_nbPoints,
            rep_libelle,rep_valeur from reponse
            inner join question using (qst_id)
            inner join quiz using (quiz_id)
            where quiz_id = $quizID;

/*------------------------------------------------------------------------
11. Requête qui compte les questions d’un quiz dont on connaît l’ID
-------------------------------------------------------------------------*/

SELECT  count(*) from reponse
            inner join question using (qst_id)
            inner join quiz using (quiz_id)
            where quiz_id = $quizID;

/*------------------------------------------------------------------------
12. Requête qui compte les bonnes réponses d’un quiz dont on connaît l’ID
-------------------------------------------------------------------------*/

SELECT  count(*) from reponse
            inner join question using (qst_id)
            inner join quiz using (quiz_id)
            where quiz_id = $quizID and
                   rep_valeur != 0 ;

/*------------------------------------------------------------------------
13. Requête qui autorise la visualisation des bonnes réponses pour un quiz
-------------------------------------------------------------------------*/

UPDATE `matchs` SET `match_visibility` = '1' WHERE `matchs`.`match_code` = $matchCode;
