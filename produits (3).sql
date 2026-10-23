-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : mar. 23 juin 2026 à 17:51
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
-- Base de données : `n8n`
--

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prix` varchar(50) NOT NULL,
  `image` varchar(150) NOT NULL,
  `categorie` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `prix`, `image`, `categorie`) VALUES
(33, 'Bracelet Maille Tressée', '800', 'bijou7.jpg', 'Bracelet'),
(34, 'Gourmette Pearl Detail', '140', 'bijou8.jpg', 'bracelet'),
(35, 'Jonc Fin Torsadé', '170', 'bijou10.jpg', 'Bracelet'),
(36, 'Collier Solitaire Pur', '130', 'bijou4.jpg', 'collier'),
(37, 'Sautoir Chaîne Élégance', '110', 'bijou2.jpg', 'collier'),
(38, 'Pendentif Cristal d\'Or', '160', 'bijou6.jpg', 'collier'),
(39, 'Choker Fin d\'Été', '120', 'colier4.jpg', 'collier'),
(40, 'Bague Couronne Impériale', '110', 'bijou1.jpg', 'bague'),
(41, 'Anneau Pavé Cristaux', '140', 'bijou9.jpg', 'bague'),
(42, 'Alliance Éclat Éternel', '100', 'bague3.jpg', 'bague'),
(43, 'Bague Torsadée Or', '70', 'bague4.jpg', 'bague'),
(45, 'Pendantes Gouttes de Rosée', '100', 'boucle4.jpg', 'boucle d\'oreille'),
(46, 'Puces d\'Oreilles Perles Célestes', '90', 'bijou12.jpg', 'boucle d\'oreille'),
(50, 'Créoles Éclat Solaire', '60', 'bijou11.jpg', 'boucle'),
(51, 'Créoles Martelées Or', '75', 'boucle3.jpg', 'boucle'),
(54, 'Jonc Rigide Miroir', '120', 'bijou5.jpg', 'Bracelet');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
