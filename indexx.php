  <?php
$filename = "notes.txt";

// Sécurité : vérifier si le fichier est accessible
if (!is_writable($filename) && file_exists($filename)) {
    die("Erreur : le fichier de notes n'est pas accessible.");
}

// Ajouter une note
if (isset($_POST['note'])) {
    $note = trim($_POST['note']);
    if (!empty($note)) {
        // Sécurité : échapper les caractères spéciaux
        $safeNote = htmlspecialchars($note, ENT_QUOTES, 'UTF-8');
        file_put_contents($filename, $safeNote . PHP_EOL, FILE_APPEND);
        $_SESSION['message'] = "Note ajoutée avec succès !";
    }
    header("Location: indexx.php");
    exit();
}

// Supprimer une note
if (isset($_GET['delete']) && ctype_digit($_GET['delete'])) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES);
    $index = (int)$_GET['delete'];
    if (isset($lines[$index])) {
        unset($lines[$index]);
        file_put_contents($filename, implode(PHP_EOL, $lines));
        $_SESSION['message'] = "Note supprimée !";
    }
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📒 Carnet de Notes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>📒 Mon Carnet de Notes</h1>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert"><?= $_SESSION['message'] ?></div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <form method="POST" class="form-note">
            <input type="text" name="note" placeholder="Écris ta note ici..." required>
            <button type="submit">Ajouter</button>
        </form>

        <?php if (!empty($notes)): ?>
            <ul class="note-list">
                <?php foreach ($notes as $index => $note): ?>
                    <li>
                        <span><?= htmlspecialchars($note, ENT_QUOTES, 'UTF-8') ?></span>
                        <a href="indexx.php?delete=<?= $index ?>" class="delete-btn" onclick="return confirm('Supprimer cette note ?')">🗑</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="empty-message">Aucune note pour le moment.</p>
        <?php endif; ?>
    </div>
</body>
</html>
