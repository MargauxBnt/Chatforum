<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/profile.css">
    <title>Ton profil - The Purrfect Place</title>
</head>
<body>
<?php require "header.php"; ?>

<?php

if (isset($_SESSION["username"])) {
    echo "<div class='welcome'>Voici ta page de profil " . $_SESSION["username"] . " !</div>";
} else {
    // Si la variable de session "username" n'est pas définie, l'utilisateur n'est pas connecté
    header("Location: index.php?action=login");
    exit();
}
?>

<h1>Tu veux modifier tes informations personnelles ? 👇</h1>
<div class="container">
<form method="POST" id="form" action="index.php?action=updateProfile">
    <label for="username"></label>
    <input type="text" name="username" value="<?= isset($user["username"]) ? $user["username"] : "" ?>" required placeholder="Nom d'utilisateur :">
    <br><br>
    <label for="email"></label>
    <input type="email" name="email" value="<?= isset($user["email"]) ? $user["email"] : "" ?>" required placeholder="Email :">
    <br><br>
    <label for="password"></label>
    <input type="password" name="password" required placeholder="Mot de passe :">
    <br><br>
    <input id="submit" type="submit" value="Enregistrer">
</form>
</div>


</body>
</html>