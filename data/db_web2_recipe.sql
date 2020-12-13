-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Ven 11 Décembre 2020 à 08:08
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

create database db_web2_recipe;
use db_web2_recipe;

-- --------------------------------------------------------

--
-- Structure de la table `t_rating`
--

CREATE TABLE `t_rating` (
  `idrating` bigint(20) UNSIGNED NOT NULL,
  `ratGrade` int(11) NOT NULL,
  `ratComment` varchar(255) DEFAULT NULL,
  `idRecipe` int(11) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `t_rating`
--

INSERT INTO `t_rating` (`idrating`, `ratGrade`, `ratComment`, `idRecipe`, `idUser`) VALUES
(1, 4, 'pas mal', 1, 1),
(2, 3, 'bof', 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `t_recipe`
--

CREATE TABLE `t_recipe` (
  `idRecipe` int(11) NOT NULL,
  `recName` varchar(100) NOT NULL,
  `recIngredientList` varchar(255) NOT NULL,
  `recDescription` varchar(255) NOT NULL,
  `recPrepTime` float NOT NULL,
  `recDifficulty` int(11) NOT NULL,
  `recGrade` int(11) DEFAULT NULL,
  `recImage` varchar(255) NOT NULL DEFAULT 'defaultRecipePicture.jpg',
  `recDate` date NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `t_recipe`
--

INSERT INTO `t_recipe` (`idRecipe`, `recName`, `recIngredientList`, `recDescription`, `recPrepTime`, `recDifficulty`, `recGrade`, `recImage`, `recDate`, `idUser`) VALUES
(1, 'recetteParDefault', 'ail, poivre, sel', 'mélange pas très bon, néanmoins faisable et très facil à réaliser.\r\nBon Appetit !!!!\r\njoyeux Noël', 1, 2, 1, 'defaultRecipePicture.jpg', '2020-11-13', 1),
(2, 'defaultRecipe2(easiest)', 'pas grand chose', 'pour le test', 1, 1, 1, 'ingredients-498199_1920.jpg', '2020-11-13', 1),
(4, 'defaultRecipe4', 'pas grand chose', 'pour le test', 1, 2, 1, 'defaultRecipePicture.jpg', '2020-11-13', 1),
(5, 'defaultRecipe5', 'pas grand chose', 'pour le test', 1, 2, 1, 'defaultRecipePicture.jpg', '2020-11-13', 1),
(6, 'defaultRecipe6', 'pas grand chose', 'pour le test', 1, 2, 1, 'defaultRecipePicture.jpg', '2020-11-13', 1),
(7, 'defaultRecipe7', 'pas grand chose', 'pour le test', 1, 2, 1, 'defaultRecipePicture.jpg', '2020-11-13', 1),
(8, 'testRecipe8', 'lol', 'idk', 500, 2, 1, 'cook-2364221_1920.jpg', '2020-11-23', 1),
(9, 'test9bestRecipe', 'pas bcp', 'trop bon', 1, 2, 5, 'egg-943413_1920.jpg', '2020-11-23', 1),
(10, 'recetteTest10', 'paspaspapspas', 'nobody wanna die', 150, 2, 3, 'cook-2364221_1920.jpg', '2020-11-23', 1),
(11, 'test', 'test', 'test', 2, 2, 2, 'cook-2364221_1920.jpg', '2020-11-30', 1),
(12, 'dfwef', 'wefwefwe', 'fwefwef', 0, 2, 2, 'defaultRecipePicture.jpg', '2020-12-03', 2);

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
(1, 'Dahïr', 'Dahïr', 'Peter', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'jmt-1018@hotmail.com', NULL, 'defaultUserPicture.png'),
(2, 'test', 'testfirstname', 'testname', 'test', NULL, NULL, 'test.png');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `t_rating`
--
ALTER TABLE `t_rating`
  ADD PRIMARY KEY (`idrating`),
  ADD UNIQUE KEY `idrating` (`idrating`),
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
  MODIFY `idrating` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `t_recipe`
--
ALTER TABLE `t_recipe`
  MODIFY `idRecipe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
