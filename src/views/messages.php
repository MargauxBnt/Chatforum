<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/messages.css">
    <title>Les messages de mon sujet</title>
</head>
<body>
<?php require "header.php"; ?>
<h1>Messages pour le sous-sujet "<?php echo $subtopic_title; ?>"<br>
(<?php echo $topic_title; ?>)</h1>





<h2>Ajouter un message</h2>
<div class="container">
    <form action="index.php?action=addMessage" method="post">
        <input type="hidden" name="subtopic_id" value="<?php echo $subtopic_id; ?>">
        <textarea name="message"></textarea>
        <button type="submit">Envoyer</button>
    </form>
</div>


<a href="index.php?action=subtopic">Retour</a>



</body>
</html>