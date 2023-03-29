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


<?php
// Récupération des messages
$messages = $postModel->getMessagesBySubtopicId($subtopic_id);

if (empty($messages)) {
    echo "Aucun message pour le moment.";
} else {
    // Affichage des messages et des réponses
    foreach ($messages as $message) {
        // Affichage du message
        ?>
        <div>
            <h3> Message </h3>
            <p> <?= $message['message'] ?> </p>
            <p> Message posté par <?= $message['username'] ?> le <?= strftime("%d/%m/%Y à %Hh%M", strtotime($message['created_at'])) ?> </p>



            <!-- Formulaire pour ajouter une réponse au message d'origine -->
            <div style='margin-left: 20px;'>
                <h3> Réponses </h3>
                <form method='post' action='index.php?action=addReply'>
                    <input type='hidden' name='message_id' value='<?= $message['message_id'] ?>'>
                    <input type='hidden' name='subtopic_id' value='<?= $subtopic_id ?>'>
                    <textarea name='content'></textarea><br>
                    <input type='submit' value='Répondre'>
                </form>
            </div>

            <?php
            // Récupération des réponses associées au message
            $replies = $postModel->getReplies($message['message_id']);

            if (!empty($replies)) {
                // Affichage des réponses
                foreach ($replies as $reply) {
                    ?>
                    <div style='margin-left: 20px;'>
                        <p> <?= $reply['content'] ?> </p>
                        <p> Réponse postée par <?= $reply['username'] ?> le <?= strftime("%d/%m/%Y à %Hh%M", strtotime($reply['created_at'])) ?> </p>

                        <!-- Formulaire pour ajouter une réponse à une réponse existante -->
                        <div style='margin-left: 20px;'>
                            <form method='post' action='index.php?action=addReply'>
                                <input type='hidden' name='message_id' value='<?= $message['message_id'] ?>'>
                                <input type='hidden' name='subtopic_id' value='<?= $subtopic_id ?>'>
                                <input type='hidden' name='parent_reply_id' value='<?= $reply['reply_id'] ?>'>
                                <textarea name='content'></textarea><br>
                                <input type='submit' value='Répondre'>
                            </form>
                        </div>
                    </div>
                    <?php
                }
            }
        ?>
        </div>
        <?php
    }
}
?>




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