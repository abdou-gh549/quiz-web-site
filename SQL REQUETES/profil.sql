
/*------------------------------------------------------------------------
1. Requête listant toutes les données de tous les profils
-------------------------------------------------------------------------*/
SELECT `cpt_pseudo`, `cpt_mdp`, `cpt_nom`, `cpt_prenom`, `cpt_type`, `cpt_actif` 
    FROM `compte`;

/*------------------------------------------------------------------------
2. Requête listant les données des profils des formateurs (/des administrateurs)
-------------------------------------------------------------------------*/
/* 
    formateur type == 2
*/
SELECT `cpt_pseudo`, `cpt_mdp`, `cpt_nom`, `cpt_prenom`,  `cpt_actif` 
    FROM `compte`
        WHERE cpt_type = 2;

/* 
    administrateur type == 1
*/
SELECT `cpt_pseudo`, `cpt_mdp`, `cpt_nom`, `cpt_prenom`,  `cpt_actif` 
    FROM `compte`
        WHERE cpt_type = 1;


/*------------------------------------------------------------------------
3. Requête de vérification des données de connexion (login et mot de passe)
-------------------------------------------------------------------------*/
/*
    var :
        $userPseudo
        $psw

*/
SELECT 1 
    FROM compte 
        WHERE cpt_pseudo = $userPseudo and
              cpt_mdp = $psw;


/*------------------------------------------------------------------------
4. Requête récupérant les données d'un profil particulier (utilisateur connecté)
-------------------------------------------------------------------------*/
/*
    var :
        $userPseudo

*/
SELECT `cpt_pseudo`, `cpt_mdp`, `cpt_nom`, `cpt_prenom`,  `cpt_actif`
       FROM compte
            WHERE cpt_pseudo = $userPseudo;

/*------------------------------------------------------------------------
5. Requête récupérant tous les logins des profils et l'état du profil (activé /désactivé)
-------------------------------------------------------------------------*/
SELECT `cpt_pseudo`,`cpt_actif` 
    FROM compte;
/*------------------------------------------------------------------------
6. Requête d'ajout des données d'un profil
-------------------------------------------------------------------------*/
/*
    var : 
        $userPseudo
        $psw
        $userNom
        $userPrenom
        $userType
*/
INSERT INTO  compte (`cpt_pseudo`, `cpt_mdp`, `cpt_nom`, `cpt_prenom`, `cpt_type`, `cpt_actif`)
    VALUES($userPseudo,$psw, $userNom, $userPrenom, $userType, 0);

/*------------------------------------------------------------------------
7. Requête de modification des données d'un profil
-------------------------------------------------------------------------*/
/*
    var : 
        $userPseudo
        $psw
        $userNom
        $userPrenom
        $userType
        $compteEtat
*/
UPDATE TABLE compte 
    SET `cpt_mdp` =  $psw,
        `cpt_nom` =  $userNom,
        `cpt_prenom` =  $userPrenom,
        `cpt_actif` =  $compteEtat
        WHERE  `cpt_pseudo` = $userPseudo;
 $userPseudo;


/*------------------------------------------------------------------------
8. Requête de mise à jour du mot de passe d'un profil
-------------------------------------------------------------------------*/
/*
    var:
        $psw
        $userPseudo
*/
UPDATE TABLE compte 
    SET `cpt_mdp` =  $psw
        WHERE  `cpt_pseudo` = $userPseudo;


/*------------------------------------------------------------------------
9. Requête de désactivation d'un profil
-------------------------------------------------------------------------*/
/*
    var:
        $userPseudo
*/
UPDATE TABLE compte 
    SET `cpt_actif` =  0
        WHERE  `cpt_pseudo` = $userPseudo;


/*------------------------------------------------------------------------
10. Requête de suppression d'un profil administrateur
-------------------------------------------------------------------------*/
/*
    var:
        $userPseudo
*/
DELETE FROM `compte`
    WHERE cpt_pseudo = $userPseudo and  
          cpt_type = 1;

/*------------------------------------------------------------------------
11. Requête(s) de suppression d’un compte formateur et des données associées à ce compte (sans supprimer les quiz !)
-------------------------------------------------------------------------*/
/*
    delete joueur 
    delete match 
    delete act
    delete formateur 
*/
DELIMITER //
CREATE PROCEDURE deleteFormateur( pseudo varchar(50)) 
BEGIN 
    delete from joueur 
        where match_code 
            in (
                select match_code 
                    from matchs 
                        where cpt_pseudo = pseudo
                );
    /* removing matchs */
    delete from matchs
         where cpt_pseudo = pseudo;
    /* removing response  */

    delete from compte 
        where cpt_pseudo = pseudo;
    /* removing question  */
    
END;