-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 04 Janvier 2021 à 14:55
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `db_web2_recipe`
--

-- --------------------------------------------------------

--
-- Structure de la table `t_rating`
--

CREATE TABLE `t_rating` (
  `idRating` bigint(20) UNSIGNED NOT NULL,
  `ratGrade` int(11) NOT NULL,
  `ratComment` varchar(255) DEFAULT NULL,
  `idRecipe` int(11) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `t_rating`
--

INSERT INTO `t_rating` (`idRating`, `ratGrade`, `ratComment`, `idRecipe`, `idUser`) VALUES
(1, 4, 'pas mal, pas mal, pas mal, pas mal, pas mal, pas mal, pas mal, pas mal, pas mal, pas mal, pas mal, pas mal, pas mal, pas mal, pas mal, pas mal, pas mal, pas mal, pas mal.', 1, 1),
(2, 3, 'bof', 1, 2),
(25, 4, 'vraiment moyen						', 1, 3),
(26, 1, 'noComment', 2, 3),
(27, 3, 'noComment', 4, 3),
(28, 4, 'noComment', 5, 3),
(29, 2, 'noCommentxvsdgsdg', 7, 3),
(30, 2, 'bof', 2, 4);

-- --------------------------------------------------------

--
-- Structure de la table `t_recipe`
--

CREATE TABLE `t_recipe` (
  `idRecipe` int(11) NOT NULL,
  `recName` varchar(100) NOT NULL,
  `recCategory` varchar(100) NOT NULL DEFAULT 'pâtisserie',
  `recIngredientList` varchar(255) NOT NULL,
  `recDescription` varchar(255) NOT NULL,
  `recPreparation` varchar(255) NOT NULL,
  `recPrepTime` int(11) NOT NULL,
  `recDifficulty` int(11) NOT NULL,
  `recGrade` float DEFAULT NULL,
  `recImage` varchar(255) NOT NULL DEFAULT 'defaultRecipePicture.jpg',
  `recDate` date NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `t_recipe`
--

INSERT INTO `t_recipe` (`idRecipe`, `recName`, `recCategory`, `recIngredientList`, `recDescription`, `recPreparation`, `recPrepTime`, `recDifficulty`, `recGrade`, `recImage`, `recDate`, `idUser`) VALUES
(1, 'recetteParDefault', 'pâtisserie', 'ail, poivre, sel, coucou, 2, r, t, t, t, t, t', 'mélange pas très bon, néanmoins faisable et très facil à réaliser.\r\nBon Appetit !!!!\r\njoyeux Noël', 'tmp,encore tmp,balek, bruler pas trop mais bruler', 1, 2, 3.66667, 'defaultRecipePicture.jpg', '2020-11-13', 1),
(2, 'defaultRecipe2(easiest)', 'pâtisserie', 'pas grand chose', 'pour le test', 'tmp', 1, 1, 1.5, 'ingredients-498199_1920.jpg', '2020-11-13', 1),
(4, 'defaultRecipe4', 'pâtisserie', 'pas grand chose', 'pour le test', 'tmp', 1, 2, 3, 'defaultRecipePicture.jpg', '2020-11-13', 1),
(5, 'defaultRecipe5', 'pâtisserie', 'pas grand chose', 'pour le test', 'tmp', 1, 2, 4, 'defaultRecipePicture.jpg', '2020-11-13', 1),
(6, 'defaultRecipe6', 'pâtisserie', 'pas grand chose', 'pour le test', 'tmp', 1, 2, 1, 'defaultRecipePicture.jpg', '2020-11-13', 1),
(7, 'defaultRecipe7', 'pâtisserie', 'pas grand chose', 'pour le test', 'tmp', 1, 2, 2, 'defaultRecipePicture.jpg', '2020-11-13', 1),
(8, 'testRecipe8', 'pâtisserie', 'lol', 'idk', 'tmp', 500, 2, 1, 'cook-2364221_1920.jpg', '2020-11-23', 3),
(9, 'test9bestRecipe', 'pâtisserie', 'pas bcp', 'trop bon', 'tmp', 1, 2, 5, 'egg-943413_1920.jpg', '2020-11-23', 1),
(10, 'recetteTest10', 'pâtisserie', 'paspaspapspas', 'nobody wanna die', 'tmp', 150, 2, 3, 'cook-2364221_1920.jpg', '2020-11-23', 1),
(11, 'test', 'pâtisserie', 'test', 'test', 'tmp', 2, 2, 2, 'cook-2364221_1920.jpg', '2020-11-30', 1),
(12, 'dfwef', 'pâtisserie', 'wefwefwe', 'fwefwef', 'tmp', 0, 2, 2, 'defaultRecipePicture.jpg', '2020-12-03', 2),
(15, 'nom de la recette', 'pâtisserie', '2 x cornichons,1 x L d\'eau,300 x g. de farine', 'première recette insérée avec le formulaire', 'couper les cornichons en fines lamelles,malaxer les cornichons avec la farine,placer la pâte créé au four pendant 5 heure', 10, 1, NULL, '20210102134517_ingredients-498199_1920.jpg', '0000-00-00', 3),
(16, 'test de suppression', 'pâtisserie', '2 x cornichons,4 x L d\'eau,11 x test', 'adasdasdasdasda', 'sadfdfewfwefwef,malaxer les cornichons avec la farine', 11, 1, NULL, 'defaultRecipePicture.jpg', '2021-01-02', 3),
(18, 'test de suppression', 'pâtisserie', '1 x wrwer', 'sdfsdfe', 'rwwerwer', 13, 1, NULL, 'defaultRecipePicture.jpg', '2021-01-03', 4),
(28, 'error', 'pâtisserie', '1 x d', 'werwe', 'salut', 10, 1, NULL, 'defaultRecipePicture.jpg', '2021-01-03', 4),
(29, 'catégorie ?', 'pas pâtisserie', '1 x cornichons', 'yvdgd', 'gdfgdfgf', 10, 1, NULL, '20210103180042_wallpapertip_dark-souls-wallpaper_33023.jpg', '2021-01-03', 4);

-- --------------------------------------------------------

--
-- Structure de la table `t_user`
--

CREATE TABLE `t_user` (
  `idUser` int(11) NOT NULL,
  `usePseudo` varchar(50) NOT NULL,
  `useFirstname` varchar(50) NOT NULL,
  `useName` varchar(50) NOT NULL,
  `usePassword` varchar(255) NOT NULL,
  `useMail` varchar(50) DEFAULT NULL,
  `useTelephone` varchar(20) DEFAULT NULL,
  `useImage` varchar(255) NOT NULL DEFAULT 'defaultUserPicture.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `t_user`
--

INSERT INTO `t_user` (`idUser`, `usePseudo`, `useFirstname`, `useName`, `usePassword`, `useMail`, `useTelephone`, `useImage`) VALUES
(1, 'Dahïr', 'Dahïr', 'Peter', '$2y$10$tGj5KNf7dL.R8/KKf0VQY.uRdWP.r3k1kztaeeohHp.5uIrKhEEAa', 'jmt-1018@hotmail.com', '', 'defaultUserPicture.png'),
(2, 'test', 'testfirstname', 'testname', '$2y$10$RMdnFfFhU14T5Bv4mLpmI.8qLd9lujzmuVOwq5TfLSgwgqEiVQkTe', NULL, NULL, '20210104140025_test.png'),
(3, 'test2', 'test2', 'test2', '$2y$10$qeXzrtQn6kL.3r3ozzNfQOcoLVJ5.uY2ugMAj4P2so54QgaaZAZYm', NULL, NULL, '20210103123527_feu.gif'),
(4, 'test3', 'test3', 'test3', '$2y$10$dOrWnxEwBJrvkvUWQD7hYuT1StzLdiNfGjRua.szTD0cGPUCho8Vy', NULL, NULL, '20210103181125_test2.png');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `t_rating`
--
ALTER TABLE `t_rating`
  ADD PRIMARY KEY (`idRating`),
  ADD UNIQUE KEY `idrating` (`idRating`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idRecipe` (`idRecipe`) USING BTREE;

--
-- Index pour la table `t_recipe`
--
ALTER TABLE `t_recipe`
  ADD PRIMARY KEY (`idRecipe`),
  ADD UNIQUE KEY `ID_t_recipe_IND` (`idRecipe`),
  ADD KEY `FKt_own_IND` (`idUser`);

--
-- Index pour la table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `ID_t_user_IND` (`idUser`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `t_rating`
--
ALTER TABLE `t_rating`
  MODIFY `idRating` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT pour la table `t_recipe`
--
ALTER TABLE `t_recipe`
  MODIFY `idRecipe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT pour la table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `t_rating`
--
ALTER TABLE `t_rating`
  ADD CONSTRAINT `t_rating_ibfk_1` FOREIGN KEY (`idRecipe`) REFERENCES `t_recipe` (`idRecipe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_rating_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `t_user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `t_recipe`
--
ALTER TABLE `t_recipe`
  ADD CONSTRAINT `FKt_own_FK` FOREIGN KEY (`idUser`) REFERENCES `t_user` (`idUser`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
