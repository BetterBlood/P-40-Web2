-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 16 Novembre 2020 à 13:34
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
-- Structure de la table `t_recipe`
--

CREATE TABLE `t_recipe` (
  `idRecipe` int(11) NOT NULL,
  `recName` varchar(100) NOT NULL,
  `recIngredientList` varchar(255) NOT NULL,
  `recDescription` varchar(255) NOT NULL,
  `recPrepTime` float NOT NULL,
  `recDifficulty` int(11) NOT NULL,
  `recNote` int(11) NOT NULL,
  `recImage` varchar(255) NOT NULL DEFAULT 'defaultRecipePicture.jpg',
  `recDate` date NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `t_recipe`
--

INSERT INTO `t_recipe` (`idRecipe`, `recName`, `recIngredientList`, `recDescription`, `recPrepTime`, `recDifficulty`, `recNote`, `recImage`, `recDate`, `idUser`) VALUES
(1, 'recetteParDefault', 'ail, poivre, sel', 'mélange pas très bon', 1, 1, 1, 'defaultRecipePicture.jpg', '2020-11-13', 1),
(2, 'defaultRecipe2', 'pas grand chose', 'pour le test', 1, 1, 1, 'defaultRecipePicture.jpg', '2020-11-13', 1),
(3, 'defaultRecipe3', 'pas grand chose', 'pour le test', 1, 1, 1, 'defaultRecipePicture.jpg', '2020-11-13', 1),
(4, 'defaultRecipe4', 'pas grand chose', 'pour le test', 1, 1, 1, 'defaultRecipePicture.jpg', '2020-11-13', 1),
(5, 'defaultRecipe5', 'pas grand chose', 'pour le test', 1, 1, 1, 'defaultRecipePicture.jpg', '2020-11-13', 1),
(6, 'defaultRecipe6', 'pas grand chose', 'pour le test', 1, 1, 1, 'defaultRecipePicture.jpg', '2020-11-13', 1),
(7, 'defaultRecipe7', 'pas grand chose', 'pour le test', 1, 1, 1, 'defaultRecipePicture.jpg', '2020-11-13', 1);

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
(1, 'Dahïr', 'Dahïr', 'Peter', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'jmt-1018@hotmail.com', NULL, 'defaultUserPicture.png');

--
-- Index pour les tables exportées
--

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
-- AUTO_INCREMENT pour la table `t_recipe`
--
ALTER TABLE `t_recipe`
  MODIFY `idRecipe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `t_recipe`
--
ALTER TABLE `t_recipe`
  ADD CONSTRAINT `FKt_own_FK` FOREIGN KEY (`idUser`) REFERENCES `t_user` (`idUser`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
