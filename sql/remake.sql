-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 27 mars 2025 à 19:38
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `remake`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id_cat` int NOT NULL AUTO_INCREMENT,
  `nom_categorie` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id_cat`, `nom_categorie`) VALUES
(1, 'Bulbes'),
(2, 'Rosiers'),
(3, 'plante à massif');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `id_commande` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `date_commande` datetime DEFAULT CURRENT_TIMESTAMP,
  `prix_total` double DEFAULT '0',
  `statut` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'En attente',
  `adresse_livraison` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_commande`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id_commande`, `id_user`, `date_commande`, `prix_total`, `statut`, `adresse_livraison`) VALUES
(38, 6, '2025-03-27 20:33:24', 36, 'Livrée', '14 rue des deux chemineux Meung Sur Loire 45130');

-- --------------------------------------------------------

--
-- Structure de la table `commande_produit`
--

DROP TABLE IF EXISTS `commande_produit`;
CREATE TABLE IF NOT EXISTS `commande_produit` (
  `id_commande` int NOT NULL,
  `id_produit` int NOT NULL,
  `quantite` int NOT NULL,
  PRIMARY KEY (`id_commande`,`id_produit`),
  KEY `id_produit` (`id_produit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commande_produit`
--

INSERT INTO `commande_produit` (`id_commande`, `id_produit`, `quantite`) VALUES
(11, 8, 2),
(12, 9, 4),
(13, 9, 2),
(13, 10, 2),
(13, 8, 3),
(14, 8, 1),
(15, 5, 4),
(15, 6, 2),
(15, 2, 3),
(15, 9, 1),
(15, 8, 1),
(15, 3, 1),
(16, 3, 1),
(17, 3, 1),
(18, 3, 1),
(19, 3, 1),
(20, 3, 1),
(21, 3, 1),
(21, 5, 1),
(22, 4, 1),
(23, 4, 10),
(24, 4, 4),
(25, 3, 900),
(26, 3, 93),
(28, 3, 1),
(28, 9, 100),
(29, 9, 7),
(30, 9, 4),
(31, 9, 1),
(32, 9, 1),
(33, 2, 2),
(34, 2, 8),
(35, 5, 1),
(36, 2, 1),
(37, 3, 1),
(38, 2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id_produit` int NOT NULL AUTO_INCREMENT,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Libelle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prix` double DEFAULT NULL,
  `quantite` int DEFAULT NULL,
  `id_cat` int NOT NULL,
  PRIMARY KEY (`id_produit`),
  KEY `id_cat` (`id_cat`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id_produit`, `image`, `Libelle`, `prix`, `quantite`, `id_cat`) VALUES
(1, '../images/bulbes_begonia.jpg', '3 bulbes de bégonias', 5, 100, 1),
(2, '../images/bulbes_dahlia.jpg', '10 bulbes de dahlias', 12, 97, 1),
(3, '../images/bulbes_glaieul.jpg', '50 glaïeuls', 9, 100, 1),
(4, '../images/massif_marguerite.jpg', 'Lot de 3 marguerites', 5, 100, 3),
(5, '../images/massif_pensee.jpg', 'Bouquet de 6 pensées', 6, 100, 3),
(6, '../images/massif_melange.jpg', 'Mélange varier de 10 plantes à massifs', 15, 100, 3),
(7, '../images/rosiers_gdefleur.jpg', '1 pied spécial \"Grande Fleurs\"', 20, 100, 2),
(8, '../images/rosiers_parfum.jpg', 'Une variété sélectionné pour son parfum', 9, 100, 2),
(9, '../images/rosiers_arbuste.jpg', 'Rosier arbuste', 8, 100, 2),
(10, '../images/rose_bleu.jpg', 'Rose Bleu', 25, 100, 2);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_users` int NOT NULL AUTO_INCREMENT,
  `login` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mot_de_passe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_users`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_users`, `login`, `mot_de_passe`, `nom`, `role`) VALUES
(1, 'admin', '$2y$10$VSdPk75Naxryjdt/W/XHauEQqkCXaFsdGmi4sDqZqcMGJ4tdJQPmS', 'Administrateurs', 'admin'),
(6, 'Nicolas', '$2y$10$XCMSYOLc4VY3dkhuOw92Xe8Jm95YeVjGfgSPwD0lJmzB0kOkA7CL.', 'Nicolas Jackson', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
