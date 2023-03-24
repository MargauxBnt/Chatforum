<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/register.css">
    <title>Inscription - The Purrfect Place</title>
</head>
<body>
<?php require "header.php"; ?>
    <h1>Inscris toi !</h1>
    <div class="container">
  <form method="POST" action="./index.php?action=register">
    <label for="username">Nom d'utilisateur:</label>
    <input type="text" name="username" required><br>
    <label for="password">Mot de passe:</label>
    <input type="password" name="password" required><br>
    <label for="email">Adresse e-mail:</label>
    <input type="email" name="email" required><br>
    <input type="submit" class="submit_form" value="S'inscrire">
  </form>
  </div>
</body>
</html>