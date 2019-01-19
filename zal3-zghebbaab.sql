-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  ven. 14 déc. 2018 à 11:04
-- Version du serveur :  10.3.9-MariaDB
-- Version de PHP :  7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `zal3-zghebbaab`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`zghebbaab`@`%` PROCEDURE `copier_quize` (`originalQuizeId` INT(20), `user_pseudo` VARCHAR(25))  BEGIN

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
    
End$$

CREATE DEFINER=`zghebbaab`@`%` PROCEDURE `delete_match` (`id` VARCHAR(8) COLLATE utf8_unicode_ci)  BEGIN
            delete from joueur 
                where match_code = id;
                
            delete from matchs
                where match_code = id;
        END$$

--
-- Fonctions
--
CREATE DEFINER=`zghebbaab`@`%` FUNCTION `insert_joueur` (`jpseudo` VARCHAR(50) COLLATE utf8_unicode_ci, `match_c` CHAR(8) COLLATE utf8_unicode_ci) RETURNS TINYINT(1) BEGIN
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

        END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `actualite`
--

CREATE TABLE `actualite` (
  `act_id` int(20) NOT NULL,
  `act_intitule` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `act_descriptif` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `act_date_debut` datetime NOT NULL,
  `act_date_fin` datetime NOT NULL,
  `cpt_pseudo` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `actualite`
--

INSERT INTO `actualite` (`act_id`, `act_intitule`, `act_descriptif`, `act_date_debut`, `act_date_fin`, `cpt_pseudo`) VALUES
(1, 'urgent', 'Chers clients, nous vous informons que notre site web sera en maintenance entre 12-12-2018 et 2019-01-12 .\r\nNous nous excusons pour ce désagrément', '2018-10-12 00:00:00', '2019-01-10 00:00:00', 'admin_tixx'),
(2, 'urgent', 'la V2  dans la phase des test ', '2018-10-12 00:00:00', '2019-01-23 00:00:00', 'admin_tixx'),
(3, 'urgent', 'la V1 online', '2018-10-12 00:00:00', '2019-01-23 00:00:00', 'admin_tixx'),
(4, 'urgent', 'V3 seras disponble dans les jours prochain', '2018-10-12 00:00:00', '2019-01-23 00:00:00', 'admin_tixx');

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE `compte` (
  `cpt_pseudo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cpt_mdp` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `cpt_nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cpt_prenom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cpt_type` int(20) NOT NULL,
  `cpt_actif` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`cpt_pseudo`, `cpt_mdp`, `cpt_nom`, `cpt_prenom`, `cpt_type`, `cpt_actif`) VALUES
('admin_tixx', 'ab883de2e08bad00d57aff67861128e6629b82efc0c6a1442f3a21711b3bf88f', 'tixx tst s', 'admin yow', 1, 1),
('formateur_tixx', '52957df1cac092095b9ca9079290bc3840f67ccc492b64aafe0024c89034f398', 'formateur mod', 'tixxoo', 2, 1),
('formateur_tixx2', 'ab883de2e08bad00d57aff67861128e6629b82efc0c6a1442f3a21711b3bf88f', 'formateur', 'tixx', 2, 0),
('formateur_tixx3', 'ab883de2e08bad00d57aff67861128e6629b82efc0c6a1442f3a21711b3bf88f', 'formateur', 'tixx3', 2, 1),
('formateur_tixx4', 'ab883de2e08bad00d57aff67861128e6629b82efc0c6a1442f3a21711b3bf88f', 'abdellah', 'ghebbache', 2, 1),
('formateur_tixx5', 'ab883de2e08bad00d57aff67861128e6629b82efc0c6a1442f3a21711b3bf88f', 'youcef', 'abbas', 2, 1),
('resletriger', 'e978f5990cbd8703bf6bfcc2bf5571a5c7e0f3ef4c6d0cd897f7174d8fe3c0aa', 'triger test', 'triger test ', 2, 1),
('responsable', 'e978f5990cbd8703bf6bfcc2bf5571a5c7e0f3ef4c6d0cd897f7174d8fe3c0aa', 'respo', 'respo', 1, 1);

--
-- Déclencheurs `compte`
--
DELIMITER $$
CREATE TRIGGER `checkCompte` BEFORE INSERT ON `compte` FOR EACH ROW BEGIN
		IF ( NEW.cpt_type > 2 || NEW.cpt_type <1) THEN
		   SET NEW.cpt_type = 2;
		END IF;
	END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

CREATE TABLE `joueur` (
  `jou_id` int(20) NOT NULL,
  `jou_pseudo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `jou_score` int(20) NOT NULL DEFAULT 0,
  `match_code` char(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`jou_id`, `jou_pseudo`, `jou_score`, `match_code`) VALUES
(4, 'tixx', 0, 'tixx14xx'),
(5, 'abdellah', 100, 'tixx14xx'),
(6, 'youcef', 200, 'tixx14xx'),
(7, 'ksksks', 50, 'tixx14xx'),
(8, 'toto', 0, '1234567s'),
(9, 'titi', 100, '1234567s'),
(10, 'tata', 200, '1234567s'),
(11, 'ohohohoh', 120, '1234567s'),
(12, 'jajajaa', 200, '1234567s'),
(13, 'jean', 0, '1234567s'),
(14, 'jaune', 50, '1234567s'),
(25, 'blablaooo', 0, 'blablabl'),
(26, 'blilll', 100, 'blablabl'),
(27, 'aasldk', 50, 'blablabl'),
(28, 'psd', 0, 'blablabl'),
(29, 'abdellah', 50, '1234567s'),
(30, 'abdellah2', 100, '1234567s'),
(31, 'ojisidfjsdff', 0, '1234567s');

-- --------------------------------------------------------

--
-- Structure de la table `matchs`
--

CREATE TABLE `matchs` (
  `match_code` char(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `match_intitule` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `match_situation` int(20) NOT NULL,
  `match_date_debut` datetime NOT NULL,
  `match_date_fin` datetime NOT NULL,
  `match_visibility` tinyint(1) NOT NULL DEFAULT 0,
  `cpt_pseudo` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `quiz_id` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `matchs`
--

INSERT INTO `matchs` (`match_code`, `match_intitule`, `match_situation`, `match_date_debut`, `match_date_fin`, `match_visibility`, `cpt_pseudo`, `quiz_id`) VALUES
('1234567s', 'info test', 1, '2018-11-26 00:00:00', '2019-11-27 00:00:00', 1, 'formateur_tixx', 2),
('blablabl', 'test de culture générale', 1, '2018-10-26 00:00:00', '2018-11-03 01:00:00', 0, 'formateur_tixx', 4),
('ifa01234', 'class ifa 1  2em test', 1, '2018-11-14 00:00:00', '2019-11-15 00:00:00', 1, 'formateur_tixx', 4),
('ifa12345', 'class Ifa 1 1er test', 1, '2018-11-24 00:00:00', '2018-11-24 01:00:00', 0, 'formateur_tixx', 1),
('tixx14xx', 'test de culture générale', 1, '2018-11-01 00:00:00', '2018-11-02 00:00:00', 0, 'formateur_tixx', 3),
('tixx15xx', 'test de culture générale', 1, '2018-11-01 00:00:00', '2018-11-02 00:00:00', 0, 'formateur_tixx', 3);

--
-- Déclencheurs `matchs`
--
DELIMITER $$
CREATE TRIGGER `calculNbMatch` AFTER INSERT ON `matchs` FOR EACH ROW BEGIN
	DECLARE nbrMatch int(20);
    
    SELECT COALESCE(COUNT(*), 0 ) INTO nbrMatch  from matchs where quiz_id = NEW.quiz_id;
    UPDATE quiz
		SET nb_match = nbrMatch
		WHERE  NEW.quiz_id = quiz.quiz_id;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `calculNbMatch2` AFTER DELETE ON `matchs` FOR EACH ROW BEGIN
	DECLARE nbrMatch int(20);
    
    SELECT COALESCE(COUNT(*), 0 ) INTO nbrMatch  from matchs where quiz_id = OLD.quiz_id;
    UPDATE quiz
		SET nb_match = nbrMatch
		WHERE  OLD.quiz_id = quiz.quiz_id;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE `question` (
  `qst_id` int(20) NOT NULL,
  `qst_libelle` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `qst_type` int(20) NOT NULL,
  `qst_ordre` int(20) NOT NULL,
  `qst_etat` int(20) NOT NULL,
  `qst_nbPoints` int(20) NOT NULL,
  `quiz_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`qst_id`, `qst_libelle`, `qst_type`, `qst_ordre`, `qst_etat`, `qst_nbPoints`, `quiz_id`) VALUES
(11, 'Qui est responsable des principes fondamentaux de la mécanique ?', 1, 2, 1, 500, 1),
(12, 'Quel est le nom du hamburger de McDonald, également appelé Quart de livre avec fromage ?', 1, 1, 1, 560, 1),
(13, 'Dans la série des X-Men, quel acteur incarne Wolverine ?', 1, 5, 1, 200, 1),
(14, 'Quels sont les prénoms de 2 frères McDonald qui ont créé la célèbre chaîne du même nom ?', 1, 4, 1, 400, 1),
(15, 'Quel artiste interprète le tube \" Berzerk \" ?', 1, 3, 1, 450, 1),
(16, 'Classez ces personnages religieux du plus ancien au plus récent ? ', 1, 1, 1, 50, 3),
(17, 'Lequel de ces fleuves français se termine par un delta ?', 1, 2, 1, 100, 3),
(18, 'Selon l\'expression: \"on garde une poire pour ...\"', 1, 3, 1, 50, 3),
(19, 'Benjamin Franklin est l\'inventeur ', 1, 4, 1, 50, 3),
(20, 'On peut photographier \"BIG BEN\" en visitant ', 1, 5, 1, 50, 3),
(21, 'Les îles Canaries se situent ?', 1, 1, 1, 50, 4),
(22, 'Les canines des animaux tels que chiens, chats, ou lions s’appellent :', 1, 3, 1, 50, 4),
(23, 'En allemand, pour dire non, on dit :', 1, 3, 1, 50, 4),
(24, 'Etre indigent c\'est être', 1, 4, 1, 50, 4),
(25, 'Dans le langage familier, comment appelle-t-on la dent du petit enfant ?', 1, 5, 1, 50, 4),
(26, 'Quel est l\'élément le plus important d\'un ordinateur, qui contient le cerveau de celui-ci', 1, 1, 1, 50, 2),
(28, 'Les imprimantes, webcam, clés USB que l\'on peut brancher à un ordinateur sont :', 1, 5, 1, 50, 2),
(29, 'Une fois l\'ordinateur allumé, et que l\'on se connecte à sa session, on arrive sur le bureau', 2, 4, 1, 50, 2),
(30, 'Une fenêtre est un rectangle permettant d\'afficher le contenu d\'un dossier, un logiciel', 1, 2, 1, 50, 2),
(35, 'Un raccourci est une icône permettant de se rendre plus rapidement vers un dossier ou un fichier', 2, 3, 1, 50, 2),
(36, 'Quel peintre, né en 1844, est également appelé « le Douanier » ?', 1, 1, 1, 60, 5),
(37, 'Dans les années 1980, quel groupe musical a chanté le titre \"Shout\" ?', 1, 2, 1, 60, 5),
(38, 'Comment appelle-t-on le versant de la montagne non situé au soleil ?', 1, 3, 1, 60, 5),
(39, 'Quelle est la seule valeur à la roulette à porter la couleur verte ?', 1, 4, 1, 60, 5),
(40, 'Quelle est la plus petite unité de mémoire utilisable sur un ordinateur ?', 1, 5, 1, 60, 5),
(41, 'Qui est responsable des principes fondamentaux de la mécanique ?', 1, 2, 1, 500, 6),
(42, 'Quel est le nom du hamburger de McDonald, également appelé Quart de livre avec fromage ?', 1, 1, 1, 560, 6),
(43, 'Dans la série des X-Men, quel acteur incarne Wolverine ?', 1, 5, 1, 200, 6),
(44, 'Quels sont les prénoms de 2 frères McDonald qui ont créé la célèbre chaîne du même nom ?', 1, 4, 1, 400, 6),
(45, 'Quel artiste interprète le tube \" Berzerk \" ?', 1, 3, 1, 450, 6);

-- --------------------------------------------------------

--
-- Structure de la table `quiz`
--

CREATE TABLE `quiz` (
  `quiz_id` int(20) NOT NULL,
  `quiz_intitule` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `quiz_descriptif` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `quiz_img` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `quiz_etat` int(20) NOT NULL,
  `cpt_pseudo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nb_match` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `quiz`
--

INSERT INTO `quiz` (`quiz_id`, `quiz_intitule`, `quiz_descriptif`, `quiz_img`, `quiz_etat`, `cpt_pseudo`, `nb_match`) VALUES
(1, 'Culture générale debutant\r\n', '', '', 1, 'formateur_tixx', 0),
(2, 'informatique', 'quiz sur les notions de base de l\'informatique', '', 1, 'formateur_tixx', 0),
(3, 'debutant 2', 'quiz culture générale pour les débutant', '', 1, 'formateur_tixx', 2),
(4, 'Culture générale debutant 3', 'quiz de culture générale pour les débutant', '', 1, 'formateur_tixx', 0),
(5, 'Culture générale debutant 4', ' ', '', 1, 'formateur_tixx2', 0),
(6, 'Culture générale debutant\r\n', '', '', 1, 'formateur_tixx2', 0);

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE `reponse` (
  `rep_id` int(20) NOT NULL,
  `rep_libelle` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `rep_valeur` int(20) NOT NULL,
  `qst_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `reponse`
--

INSERT INTO `reponse` (`rep_id`, `rep_libelle`, `rep_valeur`, `qst_id`) VALUES
(5, 'Isaac Newton', 1, 11),
(6, 'Albert Einstein', 0, 11),
(7, 'James Clerk Maxwell', 0, 11),
(8, 'Le Royal Cheese', 1, 12),
(9, 'Le Cheeseburger', 0, 12),
(10, 'Le Filet\'o Fish', 0, 12),
(11, 'Le Royal Deluxe', 0, 12),
(12, 'Matthew Fox ', 0, 13),
(13, 'Ben Affleck', 0, 13),
(14, 'Matt Damon ', 0, 13),
(15, 'Hugh Jackman', 1, 13),
(16, 'John et Peter', 0, 14),
(17, 'Richard et Maurice', 1, 14),
(18, 'Anthony et Carlos', 0, 14),
(19, 'Michael et Tom', 0, 14),
(20, 'Kanye West', 0, 15),
(21, 'Stromae', 0, 15),
(22, 'Soprano', 0, 15),
(23, 'Eminem', 1, 15),
(24, 'Jésus-Christ - Mahomet - Bouddha.', 0, 16),
(25, 'Bouddha - Jésus-Christ - Mahomet.', 1, 16),
(26, 'Mahomet. - Bouddha - Jésus-Christ.', 0, 16),
(27, 'Mahomet. - Jésus-Christ - Bouddha', 0, 16),
(28, 'la Loire', 0, 17),
(29, 'la Seine', 0, 17),
(30, 'le Rhône', 1, 17),
(31, 'l\'Adour', 0, 17),
(32, 'la soif', 1, 18),
(33, 'la chance', 0, 18),
(34, 'la faim', 0, 18),
(35, 'du paracute', 0, 19),
(36, 'du parapluie', 0, 19),
(37, 'du paratonnerre.', 1, 19),
(38, 'New Yotk', 0, 20),
(39, 'Bruxelles', 0, 20),
(40, 'Alger', 0, 20),
(41, 'Londres', 1, 20),
(42, 'en Méditerranée à l\'Est de l\'Espagne.', 0, 21),
(43, 'dans l\'Océan Atlantique au large du Maroc.', 1, 21),
(44, 'dans l\'Océan Indien', 0, 21),
(45, 'Les quenottes', 0, 22),
(46, 'Les crocs', 1, 22),
(47, 'Les babines', 0, 22),
(48, 'nein', 1, 23),
(49, 'niet', 0, 23),
(50, 'no', 0, 23),
(51, 'de nature à pardonner facilement', 0, 24),
(52, 'sans pitié, sans indulgence', 0, 24),
(53, 'dans la misère', 1, 24),
(54, 'Marmotte', 0, 25),
(55, 'Menotte', 0, 25),
(56, 'Quenotte', 1, 25),
(57, 'Bouillotte', 0, 25),
(58, 'Le clavier', 0, 26),
(59, 'La souris', 0, 26),
(60, 'L\'unité centrale', 1, 26),
(61, 'L\'écran', 0, 26),
(62, 'Des logiciels', 0, 28),
(63, 'Des composants', 0, 28),
(64, 'Des périphériques', 1, 28),
(65, 'Vrai', 1, 29),
(66, 'Faux', 0, 29),
(67, 'Vrai', 1, 30),
(68, 'Faux', 0, 30),
(69, 'Pablo Picasso', 0, 36),
(70, 'Henri Rousseau', 1, 36),
(71, 'Edgar Degas', 0, 36),
(72, 'Salvador Dali', 0, 36),
(73, 'Queen', 0, 37),
(74, 'U2', 0, 37),
(75, 'Tears For Fears', 1, 37),
(76, 'Simple Minds', 0, 37),
(77, 'Adret', 0, 38),
(78, 'Ubac', 1, 38),
(79, 'Étant', 0, 38),
(80, 'Ressac', 0, 38),
(81, 'Le zéro', 1, 39),
(82, 'Le cinquante', 0, 39),
(83, 'Le quarante', 0, 39),
(84, 'Le treize', 0, 39),
(85, 'Le byte', 0, 40),
(86, 'Le mega', 0, 40),
(87, 'Le bit', 1, 40),
(88, 'Le giga', 0, 40),
(91, 'Faux', 0, 35),
(92, 'Vrai', 1, 35),
(93, 'Isaac Newton', 1, 41),
(94, 'Albert Einstein', 0, 41),
(95, 'James Clerk Maxwell', 0, 41),
(96, 'Le Royal Cheese', 1, 42),
(97, 'Le Cheeseburger', 0, 42),
(98, 'Le Filet\'o Fish', 0, 42),
(99, 'Le Royal Deluxe', 0, 42),
(103, 'Matthew Fox ', 0, 43),
(104, 'Ben Affleck', 0, 43),
(105, 'Matt Damon ', 0, 43),
(106, 'Hugh Jackman', 1, 43),
(110, 'John et Peter', 0, 44),
(111, 'Richard et Maurice', 1, 44),
(112, 'Anthony et Carlos', 0, 44),
(113, 'Michael et Tom', 0, 44),
(117, 'Kanye West', 0, 45),
(118, 'Stromae', 0, 45),
(119, 'Soprano', 0, 45),
(120, 'Eminem', 1, 45);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `actualite`
--
ALTER TABLE `actualite`
  ADD PRIMARY KEY (`act_id`),
  ADD KEY `cpt_pseudo` (`cpt_pseudo`);

--
-- Index pour la table `compte`
--
ALTER TABLE `compte`
  ADD PRIMARY KEY (`cpt_pseudo`);

--
-- Index pour la table `joueur`
--
ALTER TABLE `joueur`
  ADD PRIMARY KEY (`jou_id`),
  ADD UNIQUE KEY `CONSTRAINT_UNIQUE_PSEUDO_MATCH` (`jou_pseudo`,`match_code`),
  ADD KEY `match_code` (`match_code`);

--
-- Index pour la table `matchs`
--
ALTER TABLE `matchs`
  ADD PRIMARY KEY (`match_code`),
  ADD KEY `cpt_pseudo` (`cpt_pseudo`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Index pour la table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`qst_id`),
  ADD KEY `question_ibfk_1` (`quiz_id`);

--
-- Index pour la table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `cpt_pseudo` (`cpt_pseudo`);

--
-- Index pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD PRIMARY KEY (`rep_id`),
  ADD KEY `qst_id` (`qst_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `actualite`
--
ALTER TABLE `actualite`
  MODIFY `act_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `joueur`
--
ALTER TABLE `joueur`
  MODIFY `jou_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `qst_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quiz_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `reponse`
--
ALTER TABLE `reponse`
  MODIFY `rep_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `actualite`
--
ALTER TABLE `actualite`
  ADD CONSTRAINT `actualite_ibfk_1` FOREIGN KEY (`cpt_pseudo`) REFERENCES `compte` (`cpt_pseudo`);

--
-- Contraintes pour la table `joueur`
--
ALTER TABLE `joueur`
  ADD CONSTRAINT `joueur_ibfk_1` FOREIGN KEY (`match_code`) REFERENCES `matchs` (`match_code`);

--
-- Contraintes pour la table `matchs`
--
ALTER TABLE `matchs`
  ADD CONSTRAINT `matchs_ibfk_1` FOREIGN KEY (`cpt_pseudo`) REFERENCES `compte` (`cpt_pseudo`),
  ADD CONSTRAINT `matchs_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`);

--
-- Contraintes pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`);

--
-- Contraintes pour la table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`cpt_pseudo`) REFERENCES `compte` (`cpt_pseudo`);

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `reponse_ibfk_1` FOREIGN KEY (`qst_id`) REFERENCES `question` (`qst_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
