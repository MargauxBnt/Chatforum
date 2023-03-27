<?php
session_start();

require_once "src/controller/controller.php";

try {
    if (isset($_GET['action']) && $_GET['action'] == "register") {
        register();
    } elseif(isset($_GET["action"]) && $_GET['action'] == "login") {
        login();
    } elseif (isset($_GET['action']) && $_GET['action'] == "profile" && isset($_SESSION['user_id'])) {
        profile();
    } elseif (isset($_GET['action']) && $_GET['action'] == "logout") {
       logout();
    } elseif (isset($_GET['action']) && $_GET['action'] == "updateProfile") {
       updateProfile();
    } elseif (isset($_GET['action']) && $_GET['action'] == "subtopic") {
        subtopic();
    } elseif (isset($_GET['action']) && $_GET['action'] == "deleteSubtopic") {
        deleteSubtopic();
    } elseif (isset($_GET['action']) && $_GET['action'] == "updateSubtopic") {
        updateSubtopic();
    } elseif (isset($_GET['action']) && $_GET['action'] == "viewMessages") {
        viewMessages();
    } elseif (isset($_GET['action']) && $_GET['action'] == "addMessage") {
        addMessage();
    } else {
       home();
    }
  } catch (Exception $e) {
    echo "Une erreur est survenue : " . $e->getMessage();
  }
  

