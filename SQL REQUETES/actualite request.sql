
/*-------------------------------------------------------------------------
 Requête listant toutes les actualités de la table des actualités et leur auteur(login)
-------------------------------------------------------------------------*/
Select act_id,act_intitule,act_descriptif,act_date_debut,act_date_fin,cpt_pseudo
    from actualite 
       where act_date_debut < NOW() and act_date_fin> NOW() ;

/*-----------------------------------------------------------------------
2. Requête donnant les données d'une actualité dont on connaît l'identifiant (n°)
-------------------------------------------------------------------------*/

Select act_id,act_intitule,act_descriptif,act_date_debut,act_date_fin,cpt_pseudo
    from actualite where act_id = "1";

/*-----------------------------------------------------------------------
3. Requête listant les 5 dernières actualités dans l'ordre décroissant
-------------------------------------------------------------------------*/

Select act_id,act_intitule,act_descriptif,act_date_debut,act_date_fin,cpt_pseudo
    from actualite
        where act_date_debut < NOW() and act_date_fin> NOW() 
        order by act_date_debut DESC  
        LIMIT 5 ;

/*------------------------------------------------------------------------
4. Requête recherchant et donnant la (ou les) actualité(s) contenant un mot
particulier
-------------------------------------------------------------------------*/

Select act_id,act_intitule,act_descriptif,act_date_debut,act_date_fin,cpt_pseudo
    from actualite
        where 
            act_descriptif Like "%tst%" 
            or 
            act_intitule Like "%tst%";

/*------------------------------------------------------------------------
5. Requête listant toutes les actualités postées à une date particulière + le login
de l’auteur
-------------------------------------------------------------------------*/

Select act_id,act_intitule,act_descriptif,act_date_debut,act_date_fin,cpt_pseudo
    from actualite
        where act_date_debut = "2018-10-12 00:00:00";

/*************************************************************************
************************ Actualités 2em part *****************************
**************************************************************************/

/*------------------------------------------------------------------------
1. Requête d'ajout d'une actualité
-------------------------------------------------------------------------*/
/*  
    var :
    $intitule
    $descreptif 
    $dateDebut
    $dateFin
    $userPseudo
*/
INSERT INTO `actualite` (`act_intitule`, `act_descriptif`, `act_date_debut`, `act_date_fin`, `cpt_pseudo`)
     VALUES ($intitule, $descreptif, $dateDebut, $dateFin, $userPseudo);
/*------------------------------------------------------------------------
2. Requête listant toutes les actualités postées par un auteur particulier
-------------------------------------------------------------------------*/
/*
    var : 
    $pseudoUser
*/
Select act_id,act_intitule,act_descriptif,act_date_debut,act_date_fin,cpt_pseudo
    from actualite 
       where act_date_debut < NOW() and 
             act_date_fin > NOW()   and 
             cpt_pseudo = $pseudoUser;

/*------------------------------------------------------------------------
3. Requête qui compte les actualités à une date précise
-------------------------------------------------------------------------*/
/*
    var :
    $datePrecise 
*/
select count(*) 
    from actualite 
        where  act_date_debut < $datePrecise and 
               act_date_fin > $datePrecise;
    
/*------------------------------------------------------------------------
4. Requête de modification d'une actualité
-------------------------------------------------------------------------*/
/*
    var:
        $actId
        $intitule
        $descreptif 
        $dateDebut
        $dateFin
        $userPseudo        
*/
update table actualite 
    set act_intitule = $intitule,
        act_descriptif = $descreptif,
        act_date_debut = $dateDebut ,
        act_id = $actId,
        act_date_fin = $dateFin ,
        where act_id = $actId and
              cpt_pseudo = $userPseudo; 


/*------------------------------------------------------------------------
5. Requête de suppression d'une actualité à partir de son ID (n°)
-------------------------------------------------------------------------*/
/*
    var :
        $actId
*/
DELETE from actualite where act_id = $actId;
/*------------------------------------------------------------------------
6. Requête supprimant toutes les actualités postées par un auteur particulier
-------------------------------------------------------------------------*/
/*
    var :
        $userPseudo
*/
DELETE from actualite where cpt_pseudo = $userPseudo;

