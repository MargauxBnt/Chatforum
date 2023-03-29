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


class PostModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getTopics() {
        $stmt = $this->db->prepare("SELECT * FROM topics ORDER BY title ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubtopics($topic_id) {
        $stmt = $this->db->prepare("SELECT * FROM subtopics WHERE topic_id = :topic_id ORDER BY created_at DESC");
        $stmt->bindValue(":topic_id", $topic_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getSubtopicsByUserId($userId) {
        $sql = "SELECT subtopics.*, topics.title AS topic_title FROM subtopics JOIN topics ON subtopics.topic_id = topics.topic_id WHERE user_id = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$userId]);
        return $query->fetchAll();
    }
    
    public function getSubtopicById($subtopicId) {
        $sql = "SELECT subtopics.*, topics.title AS topic_title FROM subtopics JOIN topics ON subtopics.topic_id = topics.topic_id WHERE subtopic_id = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$subtopicId]);
        return $query->fetch();
    }
    

    public function addSubtopic($title, $user_id, $topic_id) {
        $stmt = $this->db->prepare("INSERT INTO subtopics (title, user_id, topic_id) VALUES (:title, :user_id, :topic_id)");
        $stmt->bindValue(":title", $title);
        $stmt->bindValue(":user_id", $user_id);
        $stmt->bindValue(":topic_id", $topic_id);
        $stmt->execute();
        $subtopics = $this->getSubtopics($topic_id);
        return array("subtopics" => $subtopics, "lastInsertId" => $this->db->lastInsertId());
    }
    

    public function updateSubtopic($subtopic_id, $title) {
        $stmt = $this->db->prepare("UPDATE subtopics SET title = :title, updated_at = NOW() WHERE subtopic_id = :subtopic_id");
        $stmt->bindValue(":title", $title);
        $stmt->bindValue(":subtopic_id", $subtopic_id);
        return $stmt->execute();
    }

    public function deleteSubtopic($subtopic_id) {
        $stmt = $this->db->prepare("DELETE FROM subtopics WHERE subtopic_id = :subtopic_id");
        $stmt->bindValue(":subtopic_id", $subtopic_id);
        return $stmt->execute();
    } 
    
    public function addMessage($message, $user_id, $subtopic_id, $topic_id) {
        $stmt = $this->db->prepare("INSERT INTO messages (message, user_id, subtopic_id, topic_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$message, $user_id, $subtopic_id, $topic_id]);
        return $this->db->lastInsertId();
    }    
 

    public function getMessages($message_id) {
        $stmt = $this->db->prepare("SELECT messages.*, users.username FROM messages JOIN users ON messages.user_id = users.user_id WHERE parent_id = :message_id ORDER BY created_at ASC");
        $stmt->bindValue(":message_id", $message_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
     
    
    public function getMessagesBySubtopicId($subtopic_id) {
        $stmt = $this->db->prepare("SELECT messages.*, users.username FROM messages JOIN users ON messages.user_id = users.user_id WHERE subtopic_id = :subtopic_id ORDER BY created_at DESC");
        $stmt->bindValue(":subtopic_id", $subtopic_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }     
    

}
