<?php

// Vérifie si l'utilisateur est connecté en vérifiant si la variable de session est définie
function isUserLoggedIn() {
  return isset($_SESSION['user_id']);
}


