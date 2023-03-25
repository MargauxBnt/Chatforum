<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/subtopic.css">
    <title>Echangez avec the Purrfect Place</title>
</head>
<body>
<?php require "header.php"; ?>

<?php if (isset($_GET['successMsg'])): ?>
    <div class="success" role="alert">
        <?php echo htmlspecialchars($_GET['successMsg']); ?>
    </div>
<?php endif; ?>


<h1>Ajouter un sujet</h1>
<div class="container">
<form action="index.php?action=subtopic" method="post">
    <div>
        <label for="topic_id">Rubrique :</label>
        <select id="topic_id" name="topic_id">
    <?php foreach ($topics as $topic) : ?>
    <option value="<?php echo $topic['topic_id']; ?>"><?php echo $topic['title']; ?></option>
    <?php endforeach; ?>
    </select>
    </div>
    <div>
        <label for="title">Titre :</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div>
        <input type="submit" class="submit_form" value="Ajouter">
    </div>
</form>
</div>

<h2>Liste des sous sujets crées</h2>
<div class="subtopics-container">
    <?php foreach ($subtopics as $subtopic) : ?>
        <div class="subtopic">
            <?php echo $subtopic['title']; ?> (<?php echo $subtopic['topic_title']; ?>)
            <form action="index.php?action=deleteSubtopic" method="post">
                <input type="hidden" name="subtopic_id" value="<?php echo $subtopic['subtopic_id']; ?>">
                <input type="submit" class="submit_form" value="Supprimer">
            </form>
            <form action="index.php?action=updateSubtopic" method="post">
                <input type="hidden" name="subtopic_id" value="<?php echo $subtopic['subtopic_id']; ?>">
                <input type="text" name="title" value="<?php echo $subtopic['title']; ?>">
                <input type="submit" class="submit_form" value="Modifier">
            </form>
            <form method="post" action="index.php?action=viewMessages&subtopic_id=<?php echo $subtopic['subtopic_id']; ?>">
                <input type="hidden" name="subtopic_id" value="<?php echo $subtopic['subtopic_id']; ?>">
                <input type="submit" name="view_messages" class="submit_form_view" value="Voir les messages">
            </form>
        </div>
    <?php endforeach; ?>
</div>



</body>
</html>