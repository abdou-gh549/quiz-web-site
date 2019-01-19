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

    #copy quiz and add it as new quiz with new pseudo
    CREATE TEMPORARY TABLE tmptable_1 SELECT * FROM quiz WHERE quiz_id = originalQuizeId;
    UPDATE tmptable_1 SET quiz_id = NULL;
    UPDATE tmptable_1 SET cpt_pseudo = user_pseudo;
    INSERT INTO quiz SELECT * FROM tmptable_1;
    DROP TEMPORARY TABLE IF EXISTS tmptable_1;

    # get new quiz id 
    select new_q.quiz_id into newQuizeID 
        from quiz new_q
        inner join quiz old_q 
            on new_q.quiz_intitule = old_q.quiz_intitule and
            new_q.quiz_descriptif = old_q.quiz_descriptif and
            new_q.quiz_img = old_q.quiz_img and
            new_q.cpt_pseudo = user_pseudo
            order by quiz_id DESC LIMIT 1;
    # copy all question of originale quize
    
    
    OPEN allOriginalQuizQuestionIdCursor;
    FETCH allOriginalQuizQuestionIdCursor INTO questionID;

    WHILE NOT finCurseur DO
        #COPY QUESTION INFORMATION
        CREATE TEMPORARY TABLE tmptable_1 SELECT * FROM question WHERE qst_id = questionID;
        UPDATE tmptable_1 SET quiz_id = newQuizeID;
        UPDATE tmptable_1 SET qst_id = null;
        INSERT INTO question SELECT * FROM tmptable_1;
        DROP TEMPORARY TABLE IF EXISTS tmptable_1;

        # get new question id 
        select new_q.qst_id into newQuestionID 
            from question new_q
            inner join question old_q 
                on new_q.qst_libelle = old_q.qst_libelle and
                new_q.qst_type = old_q.qst_type and
                new_q.qst_ordre = old_q.qst_ordre and
                new_q.qst_etat = old_q.qst_etat and
                new_q.qst_nbPoints = old_q.qst_nbPoints and
                new_q.quiz_id = newQuizeID
                order by qst_id DESC LIMIT 1;
        #copy reponse
        CREATE TEMPORARY TABLE tmptable_1 SELECT * FROM reponse WHERE qst_id = questionID;
        UPDATE tmptable_1 SET qst_id =  newQuestionID;
        UPDATE tmptable_1 SET rep_id = null;
        INSERT INTO reponse SELECT * FROM tmptable_1;
        DROP TEMPORARY TABLE IF EXISTS tmptable_1;
                
        FETCH allOriginalQuizQuestionIdCursor INTO questionID;
    END WHILE;
    CLOSE allOriginalQuizQuestionIdCursor;
    
End;

