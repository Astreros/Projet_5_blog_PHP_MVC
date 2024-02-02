-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 02 fév. 2024 à 16:42
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog_forteroche`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date_creation` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `id_article`, `pseudo`, `content`, `date_creation`) VALUES
(10, 1, 'David', 'Je suis d\'accord, ce n\'est pas toujours facile ! Merci pour ce texte !', '2023-09-06 16:29:40'),
(11, 2, 'Alice', 'Ce texte me parle beaucoup. A chaque fois que j\'écris, ça part d\'une idée un peu farfelue et seulement après je m\'arrange pour en faire quelque chose de plus précis. ', '2023-08-12 16:31:12'),
(12, 2, 'Aristote', 'Je trouve ça vraiment difficile mais c\'est plus facile avec tes conseils !', '2023-08-21 16:31:58'),
(13, 2, 'Fatima', 'Moi je fais surtout de la musique, mais ces conseils s\'applique parfaitement. Je me demande si ça s\'applique à tous les domaines ? ', '2023-09-06 16:32:45'),
(14, 2, 'Emilie Forteroche', 'J\'en suis convaincue Fatima ! Et merci à tous pour vos commentaires !', '2023-09-06 16:33:09'),
(15, 3, 'Alice', 'Merci beaucoup ! ', '2023-08-15 16:34:03');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `link_comment_article` (`id_article`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `link_comment_article` FOREIGN KEY (`id_article`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
