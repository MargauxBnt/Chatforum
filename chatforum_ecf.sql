-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 24 mars 2023 à 00:54
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `chatforum_ecf`
--

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  `subtopic_id` int NOT NULL,
  `topic_id` int NOT NULL,
  PRIMARY KEY (`message_id`),
  KEY `user_id` (`user_id`),
  KEY `subtopic_id` (`subtopic_id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `subtopics`
--

DROP TABLE IF EXISTS `subtopics`;
CREATE TABLE IF NOT EXISTS `subtopics` (
  `subtopic_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  `topic_id` int NOT NULL,
  PRIMARY KEY (`subtopic_id`),
  KEY `user_id` (`user_id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `topics`
--

DROP TABLE IF EXISTS `topics`;
CREATE TABLE IF NOT EXISTS `topics` (
  `topic_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`topic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `topics`
--

INSERT INTO `topics` (`topic_id`, `title`, `created_at`) VALUES
(1, 'Santé', '2023-03-24 00:15:40'),
(2, 'Alimentation', '2023-03-24 00:16:01'),
(3, 'Chasse & pêche', '2023-03-24 00:16:16'),
(4, 'Maison & cachettes', '2023-03-24 00:16:50'),
(5, 'Les humains', '2023-03-24 00:17:00'),
(6, 'Nos ennemis les chiens', '2023-03-24 00:17:14');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `created_at`, `updated_at`) VALUES
(1, 'chaussette', '$2y$10$Qx5O9CYTMxUmYLSkqePB.e9VYiwv8zchIHN5Nj3ul6Hf70HBeQ31m', 'chau@gmail.com', '2023-03-22 12:32:00', '2023-03-22 12:32:00'),
(2, 'kikinette', '$2y$10$R4EFKvObNDgdXIWinvj7VuUqNeNUmxVp1poxz.y9P7rC1jqN4RPvS', 'kikinette@gmail.com', '2023-03-22 17:00:56', '2023-03-22 17:00:56'),
(3, 'Simba', '$2y$10$HoVJOB.aWe2MjmBQD352qOQ0wUY5jaNTIxiHVUi7Q0g9E/Js/89AW', 'simba@hotmail.fr', '2023-03-22 17:17:09', '2023-03-22 17:17:09'),
(4, 'Bob', '$2y$10$6NekYkDYXzM18vbpJof3jOYuQvdm1P/kTiOWzQ5bw6CxzVAuoUNFC', 'bob@hotmail.fr', '2023-03-22 21:35:51', '2023-03-22 21:35:51'),
(5, 'Lol', '$2y$10$tP.l0I0TLTBsxTRaMza17O4n4kTrJfYf69UCIATboqgLv3.zGvsIC', 'lol@gmail.com', '2023-03-22 21:39:45', '2023-03-22 21:39:45'),
(6, 'Cacahuète', '$2y$10$pGqvL8igck1yDrZnM9uIlu37T8XqKfCG.XM6qe37tm/2QxdtnayWC', 'cacahuete@hotmail.fr', '2023-03-22 21:58:17', '2023-03-22 21:58:17'),
(7, 'Calou', '$2y$10$A.cN3BhOfDPSsGB/UBfCeeAwf8z5pNGOJpKZr.oeefYHX7FL3ZyZq', 'calou@gmail.com', '2023-03-22 22:12:32', '2023-03-22 22:12:32'),
(8, 'Malou', '$2y$10$7FchM8.u75Dr6ClpEqeWbuhBVr1RmejouErrqOcqNisJHDDPWfvyO', 'malou@hotmail.fr', '2023-03-22 22:30:06', '2023-03-22 22:30:06'),
(9, 'Kaki', '$2y$10$y5CufTxRtyrEQVb9Y/Y7ZObktz3oRAGciTaPnn/VwJ.cAPWQ27XIe', 'kaki@gmail.com', '2023-03-22 23:02:31', '2023-03-22 23:02:31'),
(10, 'Moustache', '$2y$10$2FgLzHuLlv2HQtPFOUWoaec7qIZnfd4C83ITKeW58OCrRqJ6eHyNy', 'moustache@gmail.com', '2023-03-22 23:29:41', '2023-03-22 23:29:41'),
(11, 'Heisenberg', '$2y$10$XhStuCBWmunG63LUKx4KiODXaHZpmCX9q/TK0qyYbTqnvL0G/bEVi', 'heisenberg@gmail.com', '2023-03-23 00:57:24', '2023-03-23 00:57:24'),
(12, 'Lalali', '$2y$10$AIrhOcZdCsE9CNCKkt1Ki.Nrf/OUKxtonB2aL9XdFEcT82dUURvMe', 'lalali@gmail.com', '2023-03-23 01:17:50', '2023-03-23 01:17:50'),
(13, 'Monk', '$2y$10$BC7e7k6Rbljp.wkQUAFrYerua6AST6bx30fssv.pEKi/jR2XkVdyW', 'monk@gmail.com', '2023-03-23 01:27:03', '2023-03-23 01:27:03'),
(14, 'Catcat', '$2y$10$GrVgRvZM/eE2Zblf4wrszu86cY/9aW.hejQPTZxXp5oRXpIlP5XTu', 'cat@hotmail.fr', '2023-03-23 01:29:49', '2023-03-23 01:29:49'),
(15, 'Oklm', '$2y$10$B.5AzXBzkZOVi/meihTn..ylMgwesx9COnzCi1PpJN/HWS4MLfdFW', 'oklm@hotmail.fr', '2023-03-23 02:00:29', '2023-03-23 02:00:29'),
(16, 'Merguez', '$2y$10$uZ4E7acUDWC915tcGtv5rePQvy.hZgI/StoTe6SF08zNw1vC9SfEi', 'merguez@gmail.com', '2023-03-23 02:26:12', '2023-03-23 02:26:12'),
(17, 'BN', '$2y$10$aJpw7KfQ2BzYMfRwLQHbvuyiqMCLl36BD8xCzRKlK52jc9rBfYmx6', 'bn@hotmail.fr', '2023-03-23 02:33:54', '2023-03-23 02:33:54'),
(18, 'fripouille', '$2y$10$teVbzA9YKtd7rfhhc8.DNe3dlEjgEAXWBHkyvJQYc1R/jr8bKPqne', 'fripouille@gmail.com', '2023-03-23 02:45:49', '2023-03-23 02:45:49'),
(19, 'Marty132000', '$2y$10$oTJF0aK9J9dWt2Us741dhu3AqzTHHTaJXcnrn4MUgL30L.uDRqzvO', 'marty@gmail.com', '2023-03-23 13:21:11', '2023-03-23 14:55:29'),
(20, 'Berlioz', '$2y$10$ylE6ahhKaf8zW7ngEx8WY.n/T6RfZMyzq2Un1KZYBvQX6pcppLnc2', 'berlioz@gmail.com', '2023-03-23 15:07:27', '2023-03-23 15:07:27'),
(23, 'marg', '$2y$10$5uXm70Sdnu5mxQJ1jpM9Ye1i/CKYd17NWNp7NfCt4Vx1mqBhp0vaa', 'marty@gmail.com', '2023-03-23 15:24:28', '2023-03-23 15:24:28'),
(24, 'Tyson', '$2y$10$xxA5kdTAIfZwXEu.DsU0jO2LCwtFJrWriZcoM3LJIfGxbIK19Drpi', 'tyson@gmail.com', '2023-03-23 18:28:04', '2023-03-23 18:28:04'),
(25, 'MissMoumoune', '$2y$10$pHN0v0MoHTrzKPexv.5oWObN4bmZd73ZvxEh23x95pqmrlidfUkgu', 'missmoumoune@gmail.com', '2023-03-23 18:29:58', '2023-03-23 18:29:58'),
(26, 'KitKat', '$2y$10$TBXoc32ctZdypFBPpgpJ1uEw0lqazsSDbaisor177gbIh1uR/8342', 'kitkat@gmail.com', '2023-03-23 21:27:04', '2023-03-23 21:27:04'),
(27, 'Freshdu13', '$2y$10$.4X7XuyAENYU2L8pwduEYuTKV/NoFLF0BxyBhx25BEGqvdiQutR6O', 'fresh@gmail.com', '2023-03-23 21:44:13', '2023-03-23 22:56:36'),
(28, 'Pomme', '$2y$10$WAJ46NtMUwXtsxb5EeFKgOdmzu22GtrgaoKqPK86iNkfsbNqxQol.', 'pomme@hotmail.fr', '2023-03-23 21:46:55', '2023-03-23 21:46:55');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
