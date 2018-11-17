-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 15 nov. 2018 à 22:34
-- Version du serveur :  10.1.34-MariaDB
-- Version de PHP :  7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog_mvc`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `author` varchar(25) NOT NULL,
  `content` text NOT NULL,
  `publication_date` datetime NOT NULL,
  `modification_date` datetime DEFAULT NULL,
  `validate` tinyint(1) DEFAULT '0',
  `reported` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(50) NOT NULL,
  `synopsis` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `publication_date` datetime NOT NULL,
  `modification_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `title`, `author`, `synopsis`, `content`, `publication_date`, `modification_date`) VALUES
(1, 'Premier article', 'admin', '<p>Pellentesque vel neque feugiat, consectetur arcu a, varius turpis.</p>', '<p>Pellentesque vel neque feugiat, consectetur arcu a, varius turpis. Praesent interdum magna libero, et sollicitudin elit maximus et. Mauris fermentum justo diam, sed ultricies risus mollis eget. Quisque scelerisque urna dolor, a ornare tellus maximus id. Curabitur et odio nisi. Etiam varius ac dolor a scelerisque. Nullam dignissim arcu eros, at tristique nisl cursus sed. Vivamus bibendum leo vitae egestas convallis. Ut sed venenatis mi, eget faucibus risus. In hac habitasse platea dictumst. Etiam nisl leo, volutpat quis erat nec, tincidunt elementum felis. Morbi in commodo lorem.</p>\r\n<p>Lien: <a href=\"http://melaika-massage.fr/\">http://melaika-massage.fr/</a></p>', '2018-08-01 00:00:00', '2018-11-13 19:00:33'),
(2, 'Deuxième article', 'admin', '<p>In suscipit venenatis quam, ut elementum libero.</p>', '<p>In suscipit venenatis quam, ut elementum libero. Sed vehicula quis felis quis elementum. Aliquam pulvinar, orci rutrum pellentesque mattis, ipsum est dictum tortor, sed ultrices tortor mi vel leo. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Praesent metus erat, condimentum eget orci a, volutpat condimentum tellus. Ut a quam elit. Sed condimentum, leo in posuere feugiat, nulla lacus bibendum urna, a scelerisque tellus mauris eu mauris. Nulla ullamcorper dignissim ultrices. Aliquam a gravida dolor.</p>\r\n<p>Lien: <a href=\"http://julien-lombard.eu/chalets-et-caviar.com/\">http://julien-lombard.eu/chalets-et-caviar.com/</a></p>', '2018-10-24 17:20:00', '2018-10-24 17:25:57');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(25) NOT NULL,
  `password` varchar(50) NOT NULL,
  `register_date` datetime NOT NULL,
  `validate` tinyint(4) DEFAULT '0',
  `administrator` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `register_date`, `validate`, `administrator`) VALUES
(1, 'admin', '4a7d1ed414474e4033ac29ccb8653d9b', '2018-11-12 09:30:00', 1, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_ibfk_1` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
