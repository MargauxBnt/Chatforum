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
    // Aucun message pour le moment
    echo "Aucun message pour le moment.";
} else {
    // Affichage des messages et des réponses
    foreach ($messages as $message) {
        // Affichage du message
        echo "<div>";
        echo "<p>" . $message['message'] . "</p>";
        echo "<p>Message posté par " . $message['username'] . " le " . $message['created_at'] . "</p>";
        echo "</div>";
        
        // Récupération des réponses associées au message
        $replies = $postModel->getReplies($message['message_id']);
        
        if (!empty($replies)) {
            // Affichage des réponses
            foreach ($replies as $reply) {
                echo "<div style='margin-left: 20px;'>";
                echo "<p>" . $reply['content'] . "</p>";
                echo "<p>Réponse postée par " . $reply['username'] . " le " . $reply['created_at'] . "</p>";
                echo "</div>";
            }
        }
        
        // Formulaire pour ajouter une réponse
        echo "<div style='margin-left: 20px;'>";
        echo "<form method='post' action='index.php?action=addReply'>";
        echo "<input type='hidden' name='message_id' value='" . $message['message_id'] . "'>";
        echo "<input type='hidden' name='subtopic_id' value='" . $subtopic_id . "'>";
        echo "<textarea name='content'></textarea><br>";
        echo "<input type='submit' value='Répondre'>";
        echo "</form>";
        echo "</div>";
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