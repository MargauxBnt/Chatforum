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
    <input type="text" name="username" id="username" required placeholder="Nom d'utilisateur :"><label for="username"></label><br>
    <input type="password" name="password" id="password" required placeholder="Mot de passe :"><label for="password"></label><br>
    <input type="email" name="email" id="email" required placeholder="Email :"><label for="email"></label><br>
    <input type="submit" class="submit_form" value="Se connecter">
  </form>
</div>
<?php require "footer.php"; ?>
</body>
</html>