-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 05 avr. 2024 à 11:00
-- Version du serveur : 8.0.31
-- Version de PHP : 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `lafleur_scrum`
--

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id_cli` int NOT NULL AUTO_INCREMENT,
  `nom_cli` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prenom_cli` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `adresse_cli` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mail_cli` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `motdepasse_cli` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_cli`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id_pro` int NOT NULL AUTO_INCREMENT,
  `nom_pro` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `desc_pro` varchar(300) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prix_pro` int DEFAULT NULL,
  PRIMARY KEY (`id_pro`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE Facture (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero_facture VARCHAR(20),
    date_facture DATE,
    montant VARCHAR(20),
    client_id INT
);

CREATE TABLE Livraison (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero_livraison VARCHAR(20),
    date_livraison DATE,
    adresse_livraison VARCHAR(100),
    statut VARCHAR(20),
    facture_id INT
);

CREATE TABLE Panier (
    id INT PRIMARY KEY AUTO_INCREMENT,
    produit_id INT,
    quantite INT,
    prix_unitaire DECIMAL(10, 2)
);

CREATE USER 'nom_utilisateur'@'localhost' IDENTIFIED BY 'mot_de_passe';
GRANT SELECT, INSERT, UPDATE ON ma_base_de_donnees.ma_table TO 'nom_utilisateur'@'localhost';
