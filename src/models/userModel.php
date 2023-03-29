<?php

require_once 'connectDB.php';

class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    
    public function isUserLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    public function createUser($username, $email, $password) {
        // Vérification si l'email existe déjà dans la base de données
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Users WHERE email = :email");
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            throw new Exception("Cet e-mail est déjà utilisé.");
        }
    
        //Vérication si l'username existe déjà dans la BDD
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Users WHERE username = :username");
        $stmt->bindValue(":username", $username);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            throw new Exception("Ce nom d'utilisateur est déjà utilisé.");
        }
    
        // Hachage du mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        // Insertion dans la base de données
        $stmt = $this->db->prepare("INSERT INTO Users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->bindValue(":username", $username);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":password", $hashed_password);
        if (!$stmt->execute()) {
            throw new Exception("Erreur lors de la création de l'utilisateur.");
        }
    }
    

    public function getUserByEmail($email) {
    try {
        $stmt = $this->db->prepare("SELECT * FROM Users WHERE email = :email");
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            throw new Exception("Cet e-mail n'existe pas.");
        }
        return $user;
    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }
}

public function getUserById($userId) {
    try {
        $stmt = $this->db->prepare("SELECT * FROM Users WHERE user_id = :user_id");
        $stmt->bindValue(":user_id", $userId);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            throw new Exception("Cet utilisateur n'existe pas.");
        }
        
        return $user;
    } catch (Exception $e) {
        throw new Exception("Erreur lors de la récupération de l'utilisateur : " . $e->getMessage());
    }
}

public function getUserByUsername($username) {
    try {
    $stmt = $this->db->prepare("SELECT * FROM Users WHERE username = :username");
    $stmt->bindValue(":username", $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
    throw new Exception("Cet username n'existe pas.");
    }
    return $user;
    } catch (Exception $e) {
    throw new Exception($e->getMessage());
    }
    }

public function verifyPassword($password, $hashed_password) {
    return password_verify($password, $hashed_password);
}

public function updateUser($userId, $username, $email, $password) {
    try {
        // Vérification si l'email existe déjà dans la base de données (sauf si c'est celui de l'utilisateur)
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Users WHERE email = :email AND user_id != :user_id");
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":user_id", $userId);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            throw new Exception("Cet e-mail est déjà utilisé.");
        }

        // Vérification si le nom d'utilisateur existe déjà dans la base de données (sauf si c'est celui de l'utilisateur)
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Users WHERE username = :username AND user_id != :user_id");
        $stmt->bindValue(":username", $username);
        $stmt->bindValue(":user_id", $userId);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            throw new Exception("Ce nom d'utilisateur est déjà pris.");
        }
        
        // Hachage du mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        // Mise à jour dans la base de données
        $stmt = $this->db->prepare("UPDATE Users SET username = :username, email = :email, password = :password WHERE user_id = :user_id");
        $stmt->bindValue(":username", $username);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":password", $hashed_password);
        $stmt->bindValue(":user_id", $userId);
        if (!$stmt->execute()) {
            throw new Exception("Erreur lors de la mise à jour de l'utilisateur.");
        }

        // Mettre à jour la variable de session "username" si la modification concerne l'utilisateur connecté
        if ($_SESSION["user_id"] == $userId) {
        $_SESSION["username"] = $username;
        }
                
    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }
}
}
