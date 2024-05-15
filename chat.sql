-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 09 avr. 2024 à 14:40
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `chat`
--

-- --------------------------------------------------------

--
-- Structure de la table `conversation`
--

CREATE TABLE `conversation` (
  `idConversation` int(11) NOT NULL,
  `titre` varchar(200) NOT NULL,
  `dateCreation` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `conversation`
--

INSERT INTO `conversation` (`idConversation`, `titre`, `dateCreation`) VALUES
(1, 'Formation web', '2024-04-04'),
(2, 'Formation m&r', '2024-04-04'),
(3, 'mr', '2024-04-05'),
(4, 'dfsdfs', '2024-04-05');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `idMessage` int(11) NOT NULL,
  `contenu` varchar(255) NOT NULL,
  `idSender` int(11) NOT NULL,
  `idReceiver` int(11) NOT NULL,
  `idConversation` int(11) NOT NULL,
  `dateCreation` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`idMessage`, `contenu`, `idSender`, `idReceiver`, `idConversation`, `dateCreation`) VALUES
(7, 'bonjour', 1, 2, 1, '2024-04-09'),
(8, 'salut', 2, 1, 1, '2024-04-09'),
(11, 'Hello', 1, 3, 2, '2024-04-09'),
(12, 'salut', 3, 1, 2, '2024-04-09'),
(13, 'hifgdgfgd', 2, 3, 3, '2024-04-09'),
(14, 'fdsfsfs', 3, 2, 3, '2024-04-09');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pwd` varchar(100) NOT NULL,
  `img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idUser`, `name`, `email`, `pwd`, `img`) VALUES
(1, 'sisi', 'sisi@gmail.com', '123456', '54564646'),
(2, 'Rakoto', 'rakoto@gmail.com', '123456', 'fdsfsf'),
(3, 'Randria', 'rabe@gmail.com', '123456', 'fsdfs');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `conversation`
--
ALTER TABLE `conversation`
  ADD PRIMARY KEY (`idConversation`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`idMessage`),
  ADD KEY `idConversation` (`idConversation`),
  ADD KEY `idSender` (`idSender`,`idReceiver`),
  ADD KEY `idReceiver` (`idReceiver`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `conversation`
--
ALTER TABLE `conversation`
  MODIFY `idConversation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `idMessage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`idConversation`) REFERENCES `conversation` (`idConversation`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`idSender`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_3` FOREIGN KEY (`idReceiver`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
