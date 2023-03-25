<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les messages de mon sujet</title>
</head>
<body>
<h1>Messages pour le sous-sujet "<?php echo $subtopic_title; ?>" du sujet "<?php echo $topic_title; ?>"</h1>


<ul>
    <?php foreach ($messages as $message): ?>
        <li>
            <strong><?php echo $message["username"]; ?>:</strong>
            <?php echo $message["message"]; ?>
        </li>
    <?php endforeach; ?>
</ul>

<h2>Ajouter un message</h2>

<form action="index.php?action=addMessage" method="post">
    <input type="hidden" name="subtopic_id" value="<?php echo $subtopic_id; ?>">
    <textarea name="message"></textarea>
    <button type="submit">Envoyer</button>
</form>

<h2>Répondre à un message</h2>

<ul>
    <?php foreach ($messages as $message): ?>
        <li>
            <strong><?php echo $message["username"]; ?>:</strong>
            <?php echo $message["message"]; ?>
            <form action="index.php?action=addMessage" method="post">
                <input type="hidden" name="subtopic_id" value="<?php echo $subtopic_id; ?>">
                <input type="hidden" name="parent_id" value="<?php echo $message["id"]; ?>">
                <textarea name="message"></textarea>
                <button type="submit">Envoyer</button>
            </form>
        </li>
    <?php endforeach; ?>

    <a href="index.php?action=subtopic">Retour</a>

</ul>
</body>
</html>