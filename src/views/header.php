<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/header.css">
</head>

<body>

    <header>
    <div class="menu">
    <a href="./index.php"><img id="logo" src="./public/icons/logopoisson.png" alt="logo"></a>
    <div class="menu-buttons">
        <?php
        require_once(dirname(__DIR__) . './models/model.php');

        // Vérifie si l'utilisateur est connecté
        if (isUserLoggedIn()) {
            $user_data = getLoggedInUserData();
            echo '<a href="index.php?action=subtopic"><button action="subtopic" id="subtopic" type="button">Echanger</button></a>';
            echo '<a href="index.php?action=logout"><button action="logout" id="logout" type="button">Se déconnecter</button></a>';
        } else {
            echo '<a href="index.php?action=register"><button action="register" id="register" type="button">S\'inscrire</button></a>';
            echo '<a href="index.php?action=login"><button action="login" id="login" type="button">Se connecter</button></a>';
        }
        ?>
        <div class="user">
            <a href="index.php?action=profile" id="user-link"><img id="user" src="./public/icons/profil.png" alt="user cat"></a>
            <h6 id="h-user">Mon profil</h6>
        </div>
    </div>
</div>

    </header>
</body>

</html>