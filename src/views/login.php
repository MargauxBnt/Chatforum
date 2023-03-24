<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/login.css">
    <title>Connexion - The Purrfect Place</title>
</head>
<body>
<?php require "header.php"; ?>
<?php if (isset($_GET['success_message'])) : ?>
    <div class="success"><?= htmlspecialchars($_GET['success_message']) ?></div>
    <?php endif; ?>

    <h1>Connecte-toi !</h1>
    <div class="container">
  <form method="POST" action="./index.php?action=login">
    <label for="username">Nom d'utilisateur:</label>
    <input type="text" name="username" required><br>
    <label for="password">Mot de passe:</label>
    <input type="password" name="password" required><br>
    <label for="email">Adresse e-mail:</label>
    <input type="email" name="email" required><br>
    <input type="submit" class="submit_form" value="Se connecter">
  </form>
  </div>
</body>
</html>