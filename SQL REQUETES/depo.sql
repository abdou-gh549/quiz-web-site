/*-------------------------------------------------------------------------
•Supprimer un quiz à partir de son identifiant et toutes les données qui lui sont associées dont les matchs.

cahier de charge
Le formateur peut faire le choix de supprimer complètement un quiz, dans ce cas, il faudra supprimer toutes les
questions et les choix qui lui sont rattachés.
Dans le cas de la suppression d’un match, il faudra aussi penser à supprimer l’ensemble des participations.

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

/*-------------------------------------------------------------------------
• Supprimer un quiz à partir de son identifiant et toutes les données qui lui sont associées seulement si il
n'existe aucun match créé par un autre formateur pour le même quiz.
-------------------------------------------------------------------------*/
drop procedure IF EXISTS delete_quize2;

DELIMITER //
Create Procedure delete_quize2 (id int(20))
BEGIN
    declare formateurNumber int(20);
    select count(*) into formateurNumber 
        from matchs 
            where quiz_id = id 
                 and 
                    cpt_pseudo not in (
                            select cpt_pseudo from quiz where quiz_id = id
                    );

    if formateurNumber = 0 then
        call delete_quize(id);
    END IF;
END;


/*-------------------------------------------------------------------------
• Modifier l'ordre d'une question, s'il existait une autre question avec ce même numéro d'ordre les autres
numéros impactés sont également modifiés.
-------------------------------------------------------------------------*/
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

/*-------------------------------------------------------------------------
• Créer un nouveau quiz en copiant un quiz existant.
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
