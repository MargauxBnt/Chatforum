<?php

define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_DATABASE', 'chatforum_ecf');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

// Fonction pour se connecter à la base de données
function connectDB()
{
  try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
  } catch (PDOException $e) {
    throw new Exception("Erreur lors de la connexion à la base de données : " . $e->getMessage());
  }
}