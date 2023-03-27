<?php

require_once "./src/models/modelUser.php";
require_once "./src/models/model.php";

function register() {
        try {
            if (!isset($_POST["username"]) || !isset($_POST["email"]) || !isset($_POST["password"])) {
                throw new Exception("Il faut remplir tous les champs");
            }

            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            $db = connectDB();
            // Création d'une instance de la classe UserModel
            $userModel = new UserModel($db);
            // Création de l'utilisateur
            $userModel->createUser($username, $email, $password);
            // Message de succès d'inscription
          $success_message = "Ton inscription a bien été enregistrée.";
          // Redirection vers la page de connexion
          header("Location: index.php?action=login&success_message=".urlencode($success_message));
          exit();
        } catch (Exception $e) {
            // Affichage du message d'erreur dans la vue d'inscription
            $error_message = $e->getMessage();
            echo "<div class='error'>$error_message</div>"; 
            include "./src/views/register.php";
        }
}

function login() {
    try {
        if (!isset($_POST["email"]) || !isset($_POST["username"]) || !isset($_POST["password"])) {
            throw new Exception("Il faut remplir tous les champs.");
        }

        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        $db = connectDB();
        $userModel = new UserModel($db);

        // Récupération de l'utilisateur à partir de l'e-mail et du nom d'utilisateur
        $userByEmail = $userModel->getUserByEmail($email);
        $userByUsername = $userModel->getUserByUsername($username);

        // Vérification si les utilisateurs existent
        if (!$userByEmail || !$userByUsername) {
            throw new Exception("Le nom d'utilisateur ou l'e-mail est incorrect.");
        }

        // Vérification si l'utilisateur à partir de l'e-mail et du nom d'utilisateur est le même
        if ($userByEmail["user_id"] !== $userByUsername["user_id"]) {
            throw new Exception("Le nom d'utilisateur ou l'e-mail est incorrect.");
        }

        // Vérification du mot de passe
        if (!$userModel->verifyPassword($password, $userByEmail["password"])) {
            throw new Exception("Le mot de passe est incorrect.");
        }

        // Création de la session
        $_SESSION["user_id"] = $userByEmail["user_id"];

        // Stockage du nom d'utilisateur dans la session
        $_SESSION["username"] = $userModel->getUserById($_SESSION["user_id"])["username"];

        // Redirection vers la page de profil
        header("Location: index.php?action=profile");
        exit();
    } catch (Exception $e) {
        // Affichage du message d'erreur dans la vue de connexion
        $error_message = $e->getMessage();
        echo "<div class='error'>$error_message</div>";
        include "./src/views/login.php";
    }
}


function updateProfile() {
    try {
        if (!isset($_POST["username"]) || !isset($_POST["email"]) || !isset($_POST["password"])) {
            throw new Exception("Il faut remplir tous les champs.");
        }

        $userId = $_SESSION["user_id"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Connexion à la base de données
        $db = connectDB();
        // Création d'une instance de la classe UserModel
        $userModel = new UserModel($db);
        // Mise à jour de l'utilisateur dans la base de données
        $userModel->updateUser($userId, $username, $email, $password);
        // Récupération de l'utilisateur mis à jour
        $user = $userModel->getUserById($userId);
        // Stockage du message de succès dans une variable de session
        $_SESSION["success_message"] = "Les informations personnelles ont été mises à jour.";
        require_once "./src/views/profile.php";
    } catch (Exception $e) {
        // Affichage du message d'erreur dans la vue de profil
        require_once "./src/views/profile.php";
        // Lancement d'une nouvelle exception avec un message d'erreur détaillé
        throw new Exception($e->getMessage());
    }
}


function subtopic() {
    try {
        $db = connectDB();
        $postModel = new PostModel($db);

        // Récupération des subtopics de l'utilisateur courant avec leurs topics associés
        $subtopics = $postModel->getSubtopicsByUserId($_SESSION["user_id"]);

        // Récupération des topics existants
        $topics = $postModel->getTopics();

        // Traitement du formulaire d'ajout de subtopic
        if($_SERVER ["REQUEST_METHOD"] == "POST"){
            // Vérification de l'existence de l'utilisateur
            if (!isset($_SESSION["user_id"])) {
                throw new Exception("Tu dois être connecté(e) pour créer un sujet.");
            }
            // Vérification des données entrées par l'utilisateur
            if (!isset($_POST["title"]) || !isset($_POST["topic_id"])) {
                throw new Exception("Il faut remplir tous les champs.");
            }
            $title = $_POST["title"];
            $topic_id = $_POST["topic_id"];

            // Ajout du subtopic dans la base de données
            $subtopic_id = $postModel->addSubtopic($title, $_SESSION["user_id"], $topic_id);

            // Message de succès
            $successMsg = "Le sujet a bien été ajouté.";

            // Redirection vers la page du subtopic créé
            header("Location: index.php?action=subtopic&successMsg=".urlencode($successMsg));
            exit;
        }

        // Chargement de la vue des subtopics
        require_once './src/views/subtopic.php';
    } catch (Exception $e) {
        // Affichage de l'erreur
        $error = $e->getMessage();
        require("./src/views/subtopic.php");
    }
}

function deleteSubtopic() {
    try {
        $db = connectDB();
        $postModel = new PostModel($db);

        // Vérification de l'existence de l'utilisateur
        if (!isset($_SESSION["user_id"])) {
            throw new Exception("Tu dois être connecté(e) pour supprimer un sujet.");
        }

        // Récupération de l'ID du subtopic à supprimer
        $subtopic_id = $_POST["subtopic_id"];

        // Suppression du subtopic de la base de données
        $result = $postModel->deleteSubtopic($subtopic_id);

        if ($result) {
            $successMsg = "Le sujet a été supprimé avec succès.";
        } else {
            $errorMsg = "Une erreur s'est produite lors de la suppression du sujet.";
        }

        // Redirection vers la page des subtopics avec les messages de succès ou d'erreur
        header("Location: index.php?action=subtopic&successMsg=".urlencode($successMsg)."&errorMsg=".urlencode($errorMsg));
        exit;

    } catch (Exception $e) {
        // Affichage de l'erreur
        $error = $e->getMessage();
        require("./src/views/subtopic.php");
    }
}

function updateSubtopic() {
    try {
        $db = connectDB();
        $postModel = new PostModel($db);

        // Vérification de l'existence de l'utilisateur
        if (!isset($_SESSION["user_id"])) {
            throw new Exception("Tu dois être connecté(e) pour modifier un sujet.");
        }

        // Vérification des données entrées par l'utilisateur
        if (!isset($_POST["title"]) || !isset($_POST["subtopic_id"])) {
            throw new Exception("Il faut remplir tous les champs.");
        }
        $title = $_POST["title"];
        $subtopic_id = $_POST["subtopic_id"];

        // Mise à jour du subtopic dans la base de données
        $result = $postModel->updateSubtopic($subtopic_id, $title);

        if ($result) {
            $successMsg = "Le sujet a été modifié avec succès.";
        } else {
            $errorMsg = "Une erreur s'est produite lors de la modification du sujet.";
        }

        // Redirection vers la page des subtopics avec les messages de succès ou d'erreur
        header("Location: index.php?action=subtopic&successMsg=".urlencode($successMsg)."&errorMsg=".urlencode($errorMsg));
        exit;

    } catch (Exception $e) {
        // Affichage de l'erreur
        $error = $e->getMessage();
        require("./src/views/subtopic.php");
    }
}


function viewMessages() {
    try {
        $subtopic_id = $_GET["subtopic_id"];
        $db = connectDB();
        $postModel = new PostModel($db);

        // Vérification que le sous-sujet existe dans la base de données
        $subtopic = $postModel->getSubtopicById($subtopic_id);

        // Récupération des messages associés au sous-sujet
        //$messages = $postModel->getMessages($subtopic_id);
        $messages = $postModel->getMessagesBySubtopicId($subtopic_id);

        // Passer le titre du sous-sujet à la vue
        $subtopic_title = $subtopic['title'];
        $topic_title = $subtopic['topic_title'];

        require_once ("./src/views/messages.php");
    } catch (Exception $e) {
        // Lancement d'une nouvelle exception avec un message d'erreur détaillé
        throw new Exception("Une erreur s'est produite : " . $e->getMessage());
    }
}



function addMessage() {
    try {
        $db = connectDB();
        $postModel = new PostModel($db);

        // Récupération des données du formulaire
        $message = $_POST["message"];
        $user_id = $_SESSION["user_id"];
        $subtopic_id = $_POST["subtopic_id"];
        $parent_id = isset($_POST["parent_id"]) ? $_POST["parent_id"] : null;

        // Récupération de l'identifiant du topic associé au subtopic
        $subtopic = $postModel->getSubtopicById($subtopic_id);
        $topic_id = $subtopic["topic_id"];

        // Ajout du message ou de la réponse à la base de données
        if ($parent_id) {
            // Si un parent_id est présent dans le formulaire, on ajoute une réponse à un message existant
            $reply_id = $postModel->addReply($message, $user_id, $subtopic_id, $topic_id, $parent_id);
        } else {
            // Sinon, on ajoute un nouveau message
            $reply_id = $postModel->addMessage($message, $user_id, $subtopic_id, $topic_id);
        }

        // Récupération des réponses liées au message parent
        $replies = $postModel->getRepliesByParentId($message["message_id"]);

        // Redirection vers la page des messages
        header("Location: index.php?action=viewMessages&subtopic_id=" . $subtopic['subtopic_id']);
        exit;
    } catch (Exception $e) {
        // Lancement d'une nouvelle exception avec un message d'erreur détaillé
        throw new Exception("Une erreur s'est produite : " . $e->getMessage());
    }
}





function home() {
    require "./src/views/home.php";
}

function profile() {
    require "./src/views/profile.php";
}

function logout() {
    session_destroy();
    home();
}

function getLoggedInUserData() 
{
  try {
    $user_id = $_SESSION['user_id'];
    $db = connectDB();
    $userModel = new UserModel($db); //instanciation de la classe UserModel
    $user_data = $userModel->getUserById($user_id); // appel de la fonction getUserById depuis l'instance de UserModel
    return $user_data;
  } catch (Exception $e) {
    throw new Exception("Une erreur s'est produite : " . $e->getMessage());
  }
}

