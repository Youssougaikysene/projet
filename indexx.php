?php
$filename = "notes.txt";

// Ajouter une note
if (isset($_POST['note'])) {
    $note = trim($_POST['note']);
    if (!empty($note)) {
        file_put_contents($filename, $note . PHP_EOL, FILE_APPEND);
    }
    header("Location: indexx.php");
    exit();
}

// Supprimer une note
if (isset($_GET['delete'])) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES);
    unset($lines[$_GET['delete']]);
    file_put_contents($filename, implode(PHP_EOL, $lines) . PHP_EOL);
    header("Location: indexx.php");
    exit();
}

// Lire les notes
$notes = file_exists($filename) ? file($filename, FILE_IGNORE_NEW_LINES) : [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>📒 Carnet de Notes</title>
    <link rel="stylesheet" href="stylee.css">
</head>
<body>
<div class="container">
    <h1>📒 Mon Carnet de Notes</h1>

    <form method="POST" class="form-note">
        <input type="text" name="note" placeholder="Écris ta note ici..." required>
        <button type="submit">Ajouter la note</button>
    </form>

    <?php if (count($notes) > 0): ?>
    <ul class="note-list">
        <?php foreach ($notes as $index => $note): ?>
            <li>
                <span><?= htmlspecialchars($note) ?></span>
                <form method="GET" class="form-delete">
                    <input type="hidden" name="delete" value="<?= $index ?>">
                    <button type="submit">🗑 Supprimer</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php else: ?>
        <p class="vide">Aucune note pour le moment.</p>
    <?php endif; ?>
</div>
</body>
</html>
