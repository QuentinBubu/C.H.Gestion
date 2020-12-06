<?php

use App\User;

if (!isset($_SESSION['user'])) {
    header('Location: /');
    exit();
} else {
    $user = new User();
    $user->setInformation(json_decode($_SESSION['user'], true));
}

if (!isset($user) || $user->getInformation('service') !== 'administration') {
    require_once 'error.php';
    printError('Erreur: vous n\'avez pas les droits!');
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administrateur</title>
</head>
<body>
    <main>
        <section>
            <h3>Ajouter du personnel</h3>
        </section>
    </main>
</body>
</html>