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

<?php if (empty($messages)): ?>
    <p>Aucun message pour le moment</p>
<?php else: ?>
    <ul>
        <?php foreach ($messages as $message): ?>
            <li>
                <strong><?php echo $message["username"]; ?>:</strong>
                <?php echo $message["message"]; ?>
                <form action="index.php?action=addMessage" method="post">
                    <input type="hidden" name="subtopic_id" value="<?php echo $subtopic_id; ?>">
                    <input type="hidden" name="parent_id" value="<?php echo $message["message_id"]; ?>">
                    <textarea name="message"></textarea>
                    <input type="submit" class="submit_form" value="Répondre">
                </form>

                <?php
                // Affichage des réponses à ce message
                $replies = $postModel->getRepliesByParentId($message["message_id"]);

                if (!empty($replies)) {
                    echo "<ul>";
                    foreach ($replies as $reply) {
                        echo "<li><strong>" . $reply["username"] . " a répondu :</strong> " . $reply["message"] . "</li>";
                    }
                    echo "</ul>";
                }
                ?>

            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>



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