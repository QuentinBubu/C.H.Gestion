<?php

use App\User;

if (!isset($_SESSION['user'])) {
    header('Location: /');
    exit();
} else {
    $user = new User();
    $user->setInformation(json_decode($_SESSION['user'], true));
}

if (!isset($user)) {
    require_once 'error.php';
    printError('Erreur: vous n\'avez pas les droits!');
    exit();
}

if (isset($_POST['departure']) && isset($_POST['arrival'])) {
    $user->getRequest(
        "UPDATE `{$user->getInformation('location')}`
        SET `lits_occupes` = `lits_occupes` - :occupe
        WHERE `service` = \"{$user->getInformation('service')}\"",
        [
            'occupe' => $_POST['departure'] - $_POST['arrival']
        ]
    );
}

$all = $user->getRequest(
    "SELECT *
    FROM `{$user->getInformation('location')}`
    WHERE `service` = \"{$user->getInformation('service')}\"",
    [],
    'fetch'
);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace personnel soignant</title>
</head>
<body>

    <header>
        <h1>Bonjour <?= $user->getInformation('username') ?></h1>
        <h2>Service <?= $user->getInformation('service') ?>, hôpital <?= $user->getInformation('location') ?></h2>
    </header>

    <main>
    <section>
            <h3>Lits:</h3>
            <p>Lits disponibles: <?= $all['lits_total'] - $all['lits_occupes'] ?></p>
            <p>Lits occupés: <?= $all['lits_occupes'] ?></p>
            <p>Lits total: <?= $all['lits_total'] ?></p>
        </section>

        <section>
            <h3>Départ / arrivés:</h3>
            <form action="<?= $router->generate('soignantsPOST') ?>" method="post">
                <label for="departure">Départ(s):</label>
                <input type="number" name="departure" id="departure" min="0" value="0"/>
                <label for="arrival">Arrivée(s):</label>
                <input type="number" name="arrival" id="arrival" min="0" value="0"/>
                <button>Enregistrer</button>
            </form>
        </section>
    </main>
</body>
</html>