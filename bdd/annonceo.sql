-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 20 fév. 2018 à 16:34
-- Version du serveur :  10.1.22-MariaDB
-- Version de PHP :  7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `annonceo`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonce`
--

CREATE TABLE `annonce` (
  `id_annonce` int(3) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description_courte` varchar(255) NOT NULL,
  `description_longue` text NOT NULL,
  `prix` float NOT NULL,
  `pays` varchar(20) NOT NULL,
  `ville` varchar(20) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `cp` int(5) NOT NULL,
  `membre_id` int(3) NOT NULL,
  `categorie_id` int(3) NOT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `annonce`
--

INSERT INTO `annonce` (`id_annonce`, `titre`, `description_courte`, `description_longue`, `prix`, `pays`, `ville`, `adresse`, `cp`, `membre_id`, `categorie_id`, `date_enregistrement`) VALUES
(1, 'ANNONCE 1', 'sqdsqd', 'sdsqdsq', 456, 'France', 'Château-landon', '109 rue de la Louvetière', 77570, 1, 1, '2018-02-16 16:37:11'),
(2, 'ANNONCE 2', 'sqdsqd', 'sdsqdsq', 456, 'France', 'Château-landon', '109 rue de la Louvetière', 45000, 1, 2, '2018-02-16 16:41:18'),
(3, 'ANNONCE 3', 'sqdsqd', 'sdsqdsq', 456, 'France', 'Château-landon', '109 rue de la Louvetière', 45000, 1, 2, '2018-02-16 16:51:13'),
(4, 'ANNONCE 4', 'sdsqdq', 'ssdsqdsqd', 784, 'France', 'bourges', '109 rue de la Louvetière', 45000, 1, 3, '2018-02-16 16:52:25'),
(5, 'Skoda yeti 2.0 tdi 140cv cr 4x4 GPS 1 main 2011', 'Skoda yeti 2.0 TDI 140 cv 4x4 système 4 motion VW \r\n\r\npremiere main suivis complet Skoda \r\n\r\nprix légèrement négociable', 'Boite 6 vitesses,\r\nABS, Airbags, ESP, ASR,\r\nFermeture centralisée à distance,\r\nD.A, Clim auto,\r\n4 V.E, Rétros électriques dégivrants,\r\nLecteur CD mp3 commande au volant,\r\nGPS tactile\r\nBluetooth', 12251, 'FRANCE', 'ORLEANS', '1 RUE BERTRAND', 37124, 2, 1, '2018-02-20 11:33:31'),
(6, 'Citroën C2', 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie', 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un peintre anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n\'a pas fait que survivre cinq siècles, mais s\'est aussi adapté à la', 10000, 'France', 'RIOM', '5 rue blanche', 63000, 1, 2, '2018-02-20 15:06:06'),
(7, 'Enceintes ZADIG', 'a', 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un peintre anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n\'a pas fait que survivre cinq siècles, mais s\'est aussi adapté à la', 451, 'France', 'paris', '8 bd foch', 75009, 1, 3, '2018-02-20 15:23:09'),
(8, 'Intégrale Florence Foresti', 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie', 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un peintre anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n\'a pas fait que survivre cinq siècles, mais s\'est aussi adapté à la', 45, 'France', 'RIOM', '5 rue blanche', 63000, 1, 2, '2018-02-20 15:25:09'),
(9, 'Ford probe', 'e Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'i', 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un peintre anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n\'a pas fait que survivre cinq siècles, mais s\'est aussi adapté à la', 55000, 'France', 'paris', '1 RUE BERTRAND', 75120, 1, 3, '2018-02-20 15:42:41');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(3) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `motscles` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `titre`, `motscles`) VALUES
(1, 'Catégorie 1', ''),
(2, 'Catégorie 2', ''),
(3, 'Catégorie 3', ''),
(4, 'Catégorie 4', ''),
(5, 'Pantalon', 'fut');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id_commentaire` int(3) NOT NULL,
  `membre_id` int(3) NOT NULL,
  `annonce_id` int(3) NOT NULL,
  `commentaire` text NOT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `membre_id`, `annonce_id`, `commentaire`, `date_enregistrement`) VALUES
(1, 1, 1, 'Ceci est mon 1er commentaire', '2018-02-18 11:40:24'),
(2, 1, 1, 'Ceci est mon 2eme commentaire', '2018-02-18 11:40:24'),
(3, 1, 2, 'Ceci est mon 1er commentaire annonce 2', '2018-02-18 11:40:46');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(3) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(60) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `civilite` enum('m','f') NOT NULL,
  `statut` int(1) NOT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `telephone`, `email`, `civilite`, `statut`, `date_enregistrement`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'BRASSART', 'Olivier', '07.68.35.90.15', 'brassart_olivier@yahoo.fr', 'm', 1, '2018-02-16 12:08:39'),
(2, 'olivier', '0cc175b9c0f1b6a831c399e269772661', 'AZA', 'Aza', '02', 'brassart_olivier@yahoo.fr', 'm', 0, '2018-02-16 12:35:12'),
(3, 'isabelle658', '0cc175b9c0f1b6a831c399e269772661', 'MAURICE', 'Isabelle', '0756897845', 'isabelle.maurice@yahoo.fr', 'f', 0, '2018-02-16 12:48:46'),
(4, 'paul', '0cc175b9c0f1b6a831c399e269772661', 'PERRET', 'Paul', '025689784', 'paul.perret@yahoo.com', 'm', 0, '2018-02-16 13:57:12'),
(5, 'hubert', 'c79c6f489015e0bc97f892e357db7156', 'BRETON', 'Hubert', '0223564578', 'hubert@gamail.com', 'm', 0, '2018-02-20 16:01:48');

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE `note` (
  `id_note` int(3) NOT NULL,
  `membre_id1` int(3) NOT NULL,
  `membre_id2` int(3) NOT NULL,
  `note` int(3) NOT NULL,
  `avis` longtext NOT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `note`
--

INSERT INTO `note` (`id_note`, `membre_id1`, `membre_id2`, `note`, `avis`, `date_enregistrement`) VALUES
(1, 2, 1, 3, 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, ', '2018-02-20 10:08:04'),
(2, 1, 3, 5, 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est', '2018-02-20 10:08:38'),
(3, 3, 1, 4, '. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, ', '2018-02-20 10:08:53');

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE `photo` (
  `id_photo` int(3) NOT NULL,
  `url` varchar(255) NOT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `annonce_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `photo`
--

INSERT INTO `photo` (`id_photo`, `url`, `date_enregistrement`, `annonce_id`) VALUES
(1, '/annonceo/photos/1-voiture0.jpg', '2018-02-16 08:00:05', 1),
(2, '/annonceo/photos/1-voiture1.jpg', '2018-02-16 15:00:00', 2),
(3, '/annonceo/photos/3-voiture2.jpg', '2018-02-16 17:19:52', 2),
(4, '/annonceo/photos/1-voiture1.jpg', '2018-02-16 17:23:35', 3),
(5, '/annonceo/photos/3-voiture2.jpg', '2018-02-16 14:23:35', 1),
(6, '/annonceo/photos/4-30077c33fc89d06f92aa996cc91ad64c5c0f4e58.jpg', '2018-02-20 11:33:31', 4),
(7, '/annonceo/photos/4-e246d323fa219afe2023b1a95b7e8139b4ad1550.jpg', '2018-02-20 11:33:31', 5),
(8, '/annonceo/photos/4-ff3afdfac0842ce7af3b8908895f8eae92af4bbf.jpg', '2018-02-20 11:33:31', 5),
(9, '/annonceo/photos/5-7eff281d097ff7f1921ce7e88f3da080cb97a7e8.jpg', '2018-02-20 15:06:06', 6),
(10, '/annonceo/photos/5-649e72e01afd55578e7c2c01ee32f15f05fc945a.jpg', '2018-02-20 15:06:06', 6),
(11, '/annonceo/photos/6-1cb7791be390e803b84802d16c31f2723302f9e0.jpg', '2018-02-20 15:18:43', 0),
(12, '/annonceo/photos/6-1cb7791be390e803b84802d16c31f2723302f9e0.jpg', '2018-02-20 15:19:25', 0),
(13, '/annonceo/photos/6-1cb7791be390e803b84802d16c31f2723302f9e0.jpg', '2018-02-20 15:20:13', 0),
(14, '/annonceo/photos/6-1cb7791be390e803b84802d16c31f2723302f9e0.jpg', '2018-02-20 15:21:37', 0),
(15, '/annonceo/photos/6-1cb7791be390e803b84802d16c31f2723302f9e0.jpg', '2018-02-20 15:23:09', 7),
(16, '/annonceo/photos/7-542392d6b98d0d34e85593b3bfa4216fa5b7b91e.jpg', '2018-02-20 15:25:09', 8),
(17, '/annonceo/photos/7-d546182943210ca9e2ddcddd8389b4ba1a1b2ab0.jpg', '2018-02-20 15:25:09', 8),
(18, '/annonceo/photos/8-40111224c5575a1b17c942fb1b505e388e2b7a36.jpg', '2018-02-20 15:42:41', 9);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD PRIMARY KEY (`id_annonce`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id_commentaire`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id_note`);

--
-- Index pour la table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id_photo`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `annonce`
--
ALTER TABLE `annonce`
  MODIFY `id_annonce` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id_commentaire` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `note`
--
ALTER TABLE `note`
  MODIFY `id_note` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `photo`
--
ALTER TABLE `photo`
  MODIFY `id_photo` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
